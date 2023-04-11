<?php

namespace App\Http\Controllers;

use App\Cart;
use App\City;
use App\Contact;
use App\DefaultProduct;
use App\Dumy;
use App\Product;
use App\Province;
use App\Subdistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Midtrans\Config;
use App\Http\Controllers\Midtrans\CoreApi;
use App\Http\Controllers\Midtrans\Snap as MidtransSnap;
use App\ListTransaction;
use App\Payget;
use App\Transaction;
use App\Bank;
use App\Branch;
use App\Log_Processed_By;
Use Alert;
use Exception;

class CheckoutController extends Controller
{
    public function index(Request $req)
    {
        try {

            if (empty(session('user-session'))) {
                return redirect('/');
            }
            if (empty(session('user-session')->id)) {
                return redirect('/');
            }
            // $listtransaction = Payget::where('id_transaction', $req->id)->get()->toArray();

            $data = Cart::with(['user', 'product'])->where('id_user', session('user-session')->id)
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->get();
            $countbuy = 0;
            $sum = 0;
            $berat = 0;
            foreach ($data as $dt) {
                if ($dt->status > 0) {
                    $countbuy = $countbuy + $dt->qty;
                    $sum = $sum + ($dt->qty * $dt->product->harga);
                    $berat = $berat + ($dt->qty * $dt->product->berat);
                }
            }

            $gettotal = $sum;


            $getcontact = Contact::select('contact.*', 'contact.id as ctid', 'city.*', 'subdistrict.*', 'users.name')
                ->join('users', 'users.id', '=', 'contact.id_user')
                ->join('city', 'city.city_id', '=', 'contact.city')
                ->join('subdistrict', 'subdistrict.subdistrict_id', '=', 'contact.subdistrict')
                ->where('contact.id_user', '=', session('user-session')->id)
                ->orderBy('contact.status', 'DESC')
                ->get();

            $getaddress = Contact::select('contact.*', 'contact.id as ctid', 'city.*', 'subdistrict.*', 'users.name')
                ->join('users', 'users.id', '=', 'contact.id_user')
                ->join('city', 'city.city_id', '=', 'contact.city')
                ->join('subdistrict', 'subdistrict.subdistrict_id', '=', 'contact.subdistrict')
                ->where('contact.id_user', '=', session('user-session')->id)
                ->where('contact.pick', '=', '1')
                ->first();
            if (!$getaddress) {
                Alert::error('Alamat masih kosong, silahkan isi terlebih dahulu Alamat Anda');
                return redirect('/dashboard');
            }
            // $getaddress = Contact::where('pick', 1)->first();
            // $getcontact = Contact::where('id_user', '=' ,session('user-session')->id)->where('status', '=', 1)->get();
            // $city = City::where('city_id', $getcontact->city)->get();
            $getid = $req->id;
            $provinsi = $this->get_province();
            $getToken = "";
            $bank = Bank::all();
            return view("pages.checkout", compact('countbuy', 'sum', 'provinsi', 'getcontact', 'getToken', 'getaddress', 'berat', 'bank', 'getid'));
        } catch (Exception $e) {
            Alert::error('Transaksi gagal');
            return redirect()->back();
        }
    }
    public function checkout_midtrans(Request $req)
    {
        try {
            if (empty(session('user-session'))) {
                return redirect('/');
            }
            if (empty(session('user-session')->id)) {
                return redirect('/');
            }
            $listtransaction = Payget::where('id_transaction', $req->id)->get()->toArray();
            $gettotal = Payget::where('id_transaction', $req->id)->sum('price');
            $getemail = Contact::where('id_user', session('user-session')->id)->first();
            $params = [
                "payment_type" => "bank_transfer",
                "transaction_details" => [
                    "gross_amount" => $gettotal,
                    "order_id" => $req->id
                ],
                "item_details" => $listtransaction,
                // [
                //     "id" => "1388998298204",
                //     "price" => 10000,
                //     "quantity" => 1,
                //     "name" => "Panci Miako"
                // ],
                'customer_details' => [
                    'first_name' => session('user-session')->name,
                    'email' => session('user-session')->email,
                    'phone' => $getemail->phone,
                ]
            ];
            // dd($params);

            $snapToken = MidtransSnap::getSnapToken($params);
            $getToken = $snapToken->token;
            //  dd($snapToken->token);
            // dd(session('user-session')->id);
            $getcontact = Contact::select('contact.*', 'contact.id as ctid', 'city.*', 'subdistrict.*', 'users.name')
                ->join('users', 'users.id', '=', 'contact.id_user')
                ->join('city', 'city.city_id', '=', 'contact.city')
                ->join('subdistrict', 'subdistrict.subdistrict_id', '=', 'contact.subdistrict')
                ->where('contact.id_user', '=', session('user-session')->id)
                ->orderBy('contact.status', 'DESC')
                ->get();
            $getaddress = Contact::select('contact.*', 'contact.id as ctid', 'city.*', 'subdistrict.*', 'users.name')
                ->join('users', 'users.id', '=', 'contact.id_user')
                ->join('city', 'city.city_id', '=', 'contact.city')
                ->join('subdistrict', 'subdistrict.subdistrict_id', '=', 'contact.subdistrict')
                ->where('contact.id_user', '=', session('user-session')->id)
                ->where('contact.pick', '=', '1')
                ->first();

            // $getaddress = Contact::where('pick', 1)->first();
            // $getcontact = Contact::where('id_user', '=' ,session('user-session')->id)->where('status', '=', 1)->get();
            // $city = City::where('city_id', $getcontact->city)->get();
            $countbuy = Dumy::where('id_transaction', $req->id)->count();
            $sum = Dumy::where('id_transaction', $req->id)->sum('total');
            $berat = Dumy::where('id_transaction', $req->id)->sum('berat');
            $getid = $req->id;
            $provinsi = $this->get_province();
            return view("pages.checkout", compact('countbuy', 'sum', 'provinsi', 'getcontact', 'getaddress', 'berat', 'snapToken', 'getToken', 'getid'));
        } catch (Exception $e) {
            Alert::error('Transaksi gagal');
            return redirect()->back();
        }
    }
    public function get_province()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 752483d1f547e051295d7ad5b140b3db"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);
            $data_pengirim = $response['rajaongkir']['results'];
            return $data_pengirim;
        }
    }
    public function get_city($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/city?&province=$id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 752483d1f547e051295d7ad5b140b3db"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);
            $data_kota = $response['rajaongkir']['results'];
            return json_encode($data_kota);
        }
    }
    public function get_ongkir($origin, $destination, $destinationType, $weight, $courier)
    {
        if (empty(session('user-session'))) {
            return redirect('/');
        }
        if (empty(session('user-session')->id)) {
            return redirect('/');
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=$origin&originType=city&destination=$destination&destinationType=$destinationType&weight=$weight&courier=$courier",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 752483d1f547e051295d7ad5b140b3db"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);
            $data_ongkir = $response['rajaongkir']['results'];
            return json_encode($data_ongkir);
        }
    }
    public function changepick(Request $request)
    {
        // dd($request->nama_kota);
        if (empty(session('user-session'))) {
            return redirect('/');
        }
        if (empty(session('user-session')->id)) {
            return redirect('/');
        }
        Contact::where('pick', 1)->update([
            'pick' => '0'
        ]);
        $hsl = Contact::where('id', $request->nama_kota)->update([
            'pick' => '1'
        ]);
        if ($hsl) {
                           
            Alert::toast('Alamat berhasil diubah', 'success');
            return redirect()->back();
        } else {
            Alert::toast('Alamat gagal diubah', 'error');
            return redirect()->back();
        }
    }

    public function transaction(Request $req)
    {
        try {

            if (empty(session('user-session'))) {
                return redirect('/');
            }
            if (empty(session('user-session')->id)) {
                return redirect('/');
            }

            $a = session('user-session')->id . rand(2, 50) . date('d-m-Y');
            $b = str_replace("-", "", $a);
            $transaction = 'TR-' . str_replace(".", "-", $b);

            // $data = Dumy::where('id_transaction', $req->id_transaction)->get();
            // dd($data);
            $hasil = DB::transaction(function () use ($req, $transaction) {

                $data = Cart::with(['product', 'user'])
                    ->where('status', 1)
                    ->where('id_user', session('user-session')->id)->get();
                $sub_total = 0;
                foreach ($data as $item) {

                    $sub_total = $sub_total + ($item->product->harga * $item->qty);
                }
                $dt_bank = $req->bank;
                $a_dt_bank = explode("#", $dt_bank);
                $no_rek = $a_dt_bank[0];
                $nama_bank = $a_dt_bank[1];
                $unix_code = substr($transaction, 4, 3);
                $total_bayar = $req->total + $unix_code;
                $hsl2 = Transaction::create([
                    'id_transaction' => $transaction,
                    'id_user' => session('user-session')->id,
                    'id_address' => $req->id_address,
                    'total_berat' => $req->berat,
                    'total_ongkir' => $req->ongkir,
                    'etd' => $req->etd,
                    'kurir' => $req->kurir,
                    'layanan' => $req->layanan,
                    'sub_total' => $sub_total,
                    'total' => $req->total,
                    'unix_code' => $unix_code,
                    'total_bayar' => $total_bayar,
                    'no_rek' => $no_rek,
                    'bank' => $nama_bank
                ]);
                if ($hsl2) {

                    foreach ($data as $item) {
                        $hsl = ListTransaction::create([
                            'id_transaction' => $transaction,
                            'trans_id' => $hsl2->id,
                            'id_user' => $item->id_user,
                            'id_barang' => $item->id_barang,
                            'qty' => $item->qty,
                            'berat' => ($item->product->berat * $item->qty),
                            'total' => ($item->product->harga * $item->qty)
                        ]);
                        $hsl4 = Product::where('id', $item->id_barang)->update([
                            'stok' => ($item->product->stok - $item->qty)
                        ]);
                    }


                    $hsl3 = Payget::create([
                        'id_transaction' =>  $transaction,
                        'trans_id' => $hsl2->id,
                        'id_user' => session('user-session')->id,
                        'name' => 'Ongkir',
                        'quantity' => '1',
                        'price' =>  $req->ongkir
                    ]);
                    session(['countcart' => 0]);
                    $log_transaction = [
                        'id_transaction' => $transaction,
                        'trans_id' => $hsl2->id,
                        'status' => '0',
                        'description' => 'Menunggu Pembayaran',
                        'detail' => 'Proses Checkout ' . $hsl3,
                        'menu' => 'Customer',
                        'created_by' => session('user-session')->username
                    ];



                    log_transaction($log_transaction);
                    // throw new Exception("ada error");
                }
            });
            if (is_null($hasil)) {
                $hsl3 = Cart::where('id_user', session('user-session')->id)
                    ->where('status', 1)->delete();
                $address = Contact::find($req->id_address);
                $branch = Branch::where('subdistrict', $address->subdistrict)->first();
                if (!$branch) {
                    $branch = Branch::where('city', $address->city)->first();
                    if (!$branch) {
                        $branch = Branch::where('propinsi', $address->province)->first();
                        if (!$branch) {
                            $branch = Branch::where('main_office', true)->first();
                        }
                    }
                }
                if ($branch) {
                    $trans = Transaction::where('id_transaction', $transaction)->first();
                    if ($trans) {
                        $trans->processed_by = $branch->branch_id;
                        $trans->update();
                        Log_Processed_By::create([
                            'branch_id' => $branch->branch_id,
                            'status' => 0,
                            'ket_status' => keterangan_status(0),


                        ]);
                    }
                }
                Alert::success('Transaksi Berhasil');
                return redirect('/checkout-finish/' . $transaction);
            } else {
                Alert::error('Transaksi gagal');
                return redirect()->back();
            }
        } catch (Exception $e) {
            Alert::error('Transaksi gagal');
            return redirect()->back();
        }
    }
    public function checkout_finish(Request $req)
    {
        try {
            $no_transaksi = $req->id;
            $data = DB::select('SELECT * FROM `list_transaction`  inner join product  on list_transaction.id_barang=product.id where list_transaction.id_transaction=?', [$no_transaksi]);

            if (count($data) > 0) {
                $trans = Transaction::where('id_transaction', $no_transaksi)->first();

                $bank = Bank::where('no_akun', $trans->no_rek)->get();
                if ($trans) {
                    return view('pages.checkout-finish', compact('data', 'trans', 'no_transaksi', 'bank'));
                }
            }
        } catch (Exception $e) {
            Alert::error('Proses Checkout Gagal ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
