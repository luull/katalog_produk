<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Contact;
use App\Dumy;
use Illuminate\Http\Request;
use App\Http\Controllers\Midtrans\Snap as MidtransSnap;
use App\ListTransaction;
use App\LogTransaction;
use App\Payget;
use App\Product;
use App\Transaction;
use Exception;
Use Alert;
use Illuminate\Support\Facades\Redis;

class MyorderController extends Controller
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
            if ($req->session()->has('id_transaction')) {
                $req->session()->forget('id_transaction');
            } elseif ($req->session()->has('id_cart')) {
                $req->session()->forget('id_cart');
            }
            $transaction = Transaction::where('id_user', session('user-session')->id)->get();
            $list = ListTransaction::where('id_user', session('user-session')->id)->get();
            $product = Product::all();
            $getaddress = Contact::select('contact.*', 'contact.id as ctid', 'city.*', 'subdistrict.*', 'users.name')
                ->join('users', 'users.id', '=', 'contact.id_user')
                ->join('city', 'city.city_id', '=', 'contact.city')
                ->join('subdistrict', 'subdistrict.subdistrict_id', '=', 'contact.subdistrict')
                ->where('contact.id_user', '=', session('user-session')->id)
                ->get();
            $countcart = Cart::where('id_user', session('user-session')->id)->count();

            $resi = session()->get('manifest');
            // dd($resi);
            return view("users.myorder", compact('countcart', 'transaction', 'list', 'product', 'getaddress'));
        } catch (Exception $e) {
            Alert::error('Halaman tidak bisa ditampilkan silahkan hubungin Admin');
            return redirect()->back();
        }
    }
    public function cekresi(Request $req)
    {
        try {

            if (!empty($req->resi)) {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "waybill=$req->resi&courier=$req->kurir",
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
                    $data_resi = $response['rajaongkir']['result']['manifest'];
                    $data_paket = $response['rajaongkir']['result']['summary'];
                    $data_status = $response['rajaongkir']['result']['delivery_status'];
                    // dd($data_resi);
                    $noresi = $req->resi;
                    $idtrans = $req->id;
                    $etd = Transaction::where('resi', $noresi)->first();
                    if ($etd) {
                        if ($etd->status == 4) {
                            $proses = Transaction::find($etd->id)->update([
                                'penerima' => $data_status['pod_receiver'],
                                'status' => 5
                            ]);
                        }
                    }
                    return view("users.tracking", compact('data_resi', 'noresi', 'data_paket', 'idtrans', 'data_status', 'etd'));
                }
            } else {
                Alert::error('No Resi Masih Kosong');
                return redirect()->back();
            }
        } catch (Exception $e) {
            Alert::error('Halaman tidak bisa ditampilkan silahkan hubungin Admin');
            return redirect()->back();
        }
    }


    public function cekresi_backend(Request $req)
    {
        try {
            if (!empty($req->resi)) {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "waybill=$req->resi&courier=$req->kurir",
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
                    $data_resi = $response['rajaongkir']['result']['manifest'];
                    $data_paket = $response['rajaongkir']['result']['summary'];
                    $data_status = $response['rajaongkir']['result']['delivery_status'];
                    // dd($data_resi);
                    $noresi = $req->resi;
                    $idtrans = $req->id;
                    $etd = Transaction::where('resi', $noresi)->first();
                    if ($etd) {
                        if ($etd->status == 4) {
                            $proses = Transaction::find($etd->id)->update([
                                'penerima' => $data_status['pod_receiver'],
                                'status' => 5
                            ]);
                        }
                    }

                    // dd($data_resi);
                    return view("backend.pages.tracking", compact('data_resi', 'noresi', 'data_paket', 'idtrans', 'data_status', 'etd'));
                }
            } else {
                Alert::error('No Resi Masih Kosong');
                return redirect()->back();
            }
        } catch (Exception $e) {
            Alert::error('Halaman tidak bisa ditampilkan silahkan hubungin Admin');
            return redirect()->back();
        }
    }

    public function cekresi_branch(Request $req)
    {
        try {
            if (!empty($req->resi)) {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "waybill=$req->resi&courier=$req->kurir",
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
                    $data_resi = $response['rajaongkir']['result']['manifest'];
                    $data_paket = $response['rajaongkir']['result']['summary'];
                    $data_status = $response['rajaongkir']['result']['delivery_status'];
                    // dd($data_resi);
                    $noresi = $req->resi;
                    $idtrans = $req->id;
                    $etd = Transaction::where('resi', $noresi)->first();
                    if ($etd) {
                        if ($etd->status == 4) {
                            $proses = Transaction::find($etd->id)->update([
                                'penerima' => $data_status['pod_receiver'],
                                'status' => 5
                            ]);
                        }
                    }

                    // dd($data_resi);
                    return view("branch.pages.tracking", compact('data_resi', 'noresi', 'data_paket', 'idtrans', 'data_status', 'etd'));
                }
            } else {
                Alert::error('No Resi Masih Kosong');
                return redirect()->back();
            }
        } catch (Exception $e) {
            Alert::error('Halaman tidak bisa ditampilkan silahkan hubungin Admin');
            return redirect()->back();
        }
    }

    public function kirim_bukti_pembayaran(Request $req)
    {
        $no_trans = $req->id;
        return view('users.kirim_bukti_pembayaran', compact('no_trans'));
    }

    public function proses_kirim_bukti_pembayaran(Request $request)
    {

        try {
            $this->validate(
                $request,
                [
                    'photo' => 'mimes:jpeg,png,jpg,gif |max:2096',
                ],
                $messages = [
                    'required' => 'The :attribute field is required.',
                    'mimes' => 'Only jpeg, png are allowed.'
                ]
            );
            $photo = '';
            $trans = Transaction::find($request->id);

            if ($trans) {

                if ($request->hasfile('photo')) {
                    $photoName = $trans->id_transaction . '.' . $request->photo->extension();
                    $uid = session('user-session')->id;
                    $request->photo->move(public_path('/bukti-transfer/' . $uid), $photoName);
                    $photo = "bukti-transfer/$uid/$photoName";
                } else {
                    $photo = '';
                }
                $hsl = $trans->update([
                    'bukti_pembayaran' => $photo,
                ]);
                if ($hsl) {
                    Alert::success('Bukti pembayaran berhasil dikirim');
                    return redirect()->back();
                } else {
                    Alert::error('Bukti pembayaran gagal dikirim');
                    return redirect()->back();
                }
            } else {
                Alert::error('Bukti pembayaran gagal dikirim');
                return redirect()->back();
            }
        } catch (Exception $e) {
            Alert::error('Bukti pembayaran gagal dikirim');
            return redirect()->back();
        }
    }
    public function konfirmasi_pembayaran(Request $req)
    {
        try {
            $id = decrypt($req->id);
            $trans = Transaction::find($id);
            $cek = cek_pembayaran_by_moota($trans->total_bayar, substr($trans->date_created, 0, 10));
            $user = session('user-session')->username;
            $menu = "Customer";
            $status = 1;
            $ket_status = 'Pembayaran Terferivikasi';

            if ($cek['status'] == 200) {
                $data = json_encode($cek['data']);

                $trans->status = $status;
                $trans->detil_transaksi = $data;
                $trans->update();
                $ket_status = 'Pembayaran Terferivikasi';
                $log_transaction = [
                    'id_transaction' => $trans->id_transaction,
                    'status' => $status,
                    'description' => $ket_status,
                    'created_by' => $user,
                    'menu' => $menu,
                    'detail' => $data
                ];
                log_transaction($log_transaction);
                Alert::success($trans->id_transaction . ' telah diterima pembayaranya');
                return redirect('/myorder');
            } else {
                Alert::error($trans->id_transaction . ' belum melakukan pembayaran,<br> atau silahkan <a href="/kirim-bukti-pembayaran/' . $trans->id . '" class="text-success">kirim bukti pembayaran</a> jika memang sudah melakukan pembayaran');
                return redirect('/myorder');
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => 'Halaman tidak bisa ditampilkan silahkan hubungin Admin', 'alert' => 'danger']);
        }
    }
    public function konfirmasi_pembayaran_backend(Request $req)
    {
        try {
            $id = decrypt($req->id);
            $trans = Transaction::find($id);
            $user = session('backend-session')->username;
            $menu = "Backend";
            $status = 1;

            $cek = cek_pembayaran_by_moota($trans->total_bayar, substr($trans->date_created, 0, 10));
            if ($cek['status'] == 200) {
                $data = json_encode($cek['data']);

                $trans->status = $status;
                $trans->detil_transaksi = $data;
                $trans->update();
                $ket_status = 'Pembayaran Terferivikasi';
                $log_transaction = [
                    'id_transaction' => $trans->id_transaction,
                    'status' => $status,
                    'description' => $ket_status,
                    'created_by' => $user,
                    'menu' => $menu,
                    'detail' => $data
                ];
                log_transaction($log_transaction);
                Alert::success($trans->id_transaction . ' telah diterima pembayaranya');
                return redirect('/backend/dashboard');
            } else {
                Alert::error($trans->id_transaction . ' belum melakukan pembayaran, atau jika sudah silahkan klik tombol cek mutasi');
                return redirect('/backend/dashboard');
            }
        } catch (Exception $e) {
            Alert::error('Halaman tidak bisa ditampilkan silahkan hubungin Admin');
            return redirect()->back();
        }
    }

    public function cek_log_transaction(Request $req)
    {
        // try {
        $data = LogTransaction::where('trans_id', $req->id)
            ->whereOr('id_transaction', $req->id)->get();
        if ($data) {
            $id_transaksi = $data[0]->id_transaction;
            return view('backend.pages.log-transaction', compact('data', 'id_transaksi'));
        } else {
            Alert::error('Transaksi tidak ditemukan');
            return redirect()->back();
        }
        /* } catch (Exception $e) {
            return redirect()->back()->with(['message' => 'Halaman tidak bisa ditampilkan silahkan hubungin Admin', 'alert' => 'danger']);
        }*/
    }
}
