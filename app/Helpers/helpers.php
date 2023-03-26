<?PHP

use App\Branch;
use App\Company;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


function keterangan_status($status)
{
    $a_status = ['Belum Dibayar', 'Sudah Dibayar', 'Sudah Diproses', 'Sudah Dikemas', 'Sudah Dikirim', 'Sudah Sampai', 'Sudah Selesai', '', '', '', ' Batal'];
    return $a_status[$status];
}
function daftar_customer()
{
    $data = App\Users::orderBy('id', 'Desc')
        ->get();
    $html = '<div class="row justify-content-center" style="overflow:scroll !important">
                <div class="col-12">
                <h5 class="text-center mt-3 text-uppercase">Daftar Customer ' . env('STORE_NAME') . '</h5>
                <table align="center" class="table table-responsive table-sm" >
                <thead style="background:#eee"><tr>
                <th>#</th>
                <th>Username</th>
                <th>Nama Customer</th>
                <th>Email</th>
                <th>No Handphone</th>
                <th>Tanggal Daftar</th>
                <th>Tanggal Verifikasi</th>
                <th>Refferal</th>
                <th>Refferal ID</th>
                </tr></thead><tbody>';
    $x = 0;
    foreach ($data as $dt) {
        $x++;
        $html .= '<tr >
                    <td>' . $x . '</td>
                    <td>' . $dt->username . '</td>
                    <td>' . $dt->name . '</td>
                    <td>' . $dt->email . '</td>
                    <td>' . $dt->phone . '</td>
                  
                    <td>' . $dt->created_at . '</td>
                    <td>' . $dt->created_at . '</td>
                    <td>' . $dt->refferal . '</td>
                    <td>' . $dt->refferal_id . '</td>
                    
                    </tr>';
    }
    $html .= '</tbody></table>
                </div></div>';
    return $html;
}
function daftar_customer1($tg1, $tg2)
{
    if (empty($tg1)) {
        $tg1 = date('Y-m-d');
    }
    if (empty($tg2)) {
        $tg2 = date('Y-m-d');
    }
    $data = App\Users::where('created_at', '>=' . $tg1)
        ->where('created_at', '<=', $tg2)
        ->orderBy('id', 'Desc')
        ->get();
    $html = '<div class="row justify-content-center" style="overflow:scroll !important">
        <div class="col-md-12 " >
        <h5 class="text-center  text-uppercase mt-3">Daftar Customer ' . env('STORE_NAME') .
        ' Hari Ini</h5>
        <div class="table-responsive" >
          <table align="center" class="table table-responsive table-sm" >
              <thead style="background:#eee"><tr>
        <th>#</th>
        <th>Username</th>
                <th>Nama Customer</th>
                <th>Email</th>
                <th>No Handphone</th>
                <th>Tanggal Daftar</th>
                <th>Tanggal Verifikasi</th>
                <th>Refferal</th>
                <th>Refferal ID</th>
                </tr></thead><tbody>';
    $x = 0;
    foreach ($data as $dt) {
        $x++;
        $html .= '<tr >
                    <td>' . $x . '</td>
                    <td>' . $dt->username . '</td>
                    <td>' . $dt->name . '</td>
                    <td>' . $dt->email . '</td>
                    <td>' . $dt->phone . '</td>
                  
                    <td>' . $dt->created_at . '</td>
                    <td>' . $dt->created_at . '</td>
                    <td>' . $dt->refferal . '</td>
                    <td>' . $dt->refferal_id . '</td>
                    
                    </tr>';
    }
    $html .= '</tbody></table>
    </div>
        </div></div>';
    return $html;
}
function count_transaction($status)
{
    $count = App\Transaction::where('id_user', '=', session('user-session')->id)
        ->where('status', '=', $status)
        ->count();
    return $count;
}
function transaction($status)
{
    if (session('user-session')) {
        $trans = App\Transaction::with(['detil', 'user', 'address'])
            ->where('status', $status)
            ->where('id_user', session('user-session')->id)
            ->orderBy('id', 'Desc')
            ->get();
        $hasil = "";
        $a_status = ['Belum Dibayar', 'Sudah Dibayar', 'Sudah Diproses', 'Sudah Dikemas', 'Sudah Dikirim', 'Sudah Sampai', 'Sudah Selesai', '', '', '', ' Batal'];
        if (count($trans) > 0) {
            $hasil .= '<h4 class="text-center">Daftar Transaksi ' . $a_status[$status] . '</h4>';
        }
        $hasil .= '<div class="row">
    <div class="col-12">';
        $jml = 0;
        foreach ($trans as $t) {
            $jml++;
            $hasil .= '<div class="card ">
                <div class="card-header bg-light p-3 pb-0 m-0">
                    <div class="row justify-content-between m-0 p-0 text-dark">
                        <div class="col-7 m-0 pl-2 pr-2 "><a href="/detil-transaksi/' . $t->id_transaction . '">' . $t->id_transaction . '</a> / ' . $t->date_created . '</div> 
                        <div class="col-5 m-0 pl-2 pr-2 text-right ">' . $t->address->name . '</div> 
                    </div>
                </div>
            <div class="card-body pt-3 pb-0">
                <div class="row">';
            if ($t->detil != null) {

                foreach ($t->detil as $l) {
                    if ($l->product) {

                        $hasil .= '<div class="col-3 col-md-1 mb-3">
                                <div class="text-center">
                                    <a href="/detil-produk/' . $l->product->slug . '"><img src="' . asset($l->product->image) . '" class="img-fluid" alt="" border=0 style="max-height: 120px !important;"></a>
                                </div>
                            </div>
                            <div class="col-9 col-md-11 mb-3">
                                <p><a href="/detil-produk/' . $l->product->slug . '">' . $l->product->nama . '<br>Rp.' . number_format($l->product->harga) . '<br>' . number_format($l->qty) . ' ' . $l->product->satuan . ' </a></p>
                                
                            </div></a>';
                    }
                }
            }
            $hasil .= '</div>';
            if (!empty($t->kurir)) {
                $hasil .= ' <hr class="p-0 m-0">
            <div class="row justify-content-between pt-2 pb-2">
            <div class="col-6">';
                if (!empty($t->penerima)) {
                    $hasil .= 'Pesanan sudah diterima ' . $t->penerima;
                } else {
                    $hasil .= 'Kurir : ' . strtoupper($t->kurir) . ', Estimasi Kedatangan ' . $t->etd . ' Hari';
                }
                $hasil .= '</div>';
                if (!empty($t->resi)) {
                    $hasil .= '<div class="col-6 text-right">
            No Resi : ' . $t->resi . '
            </div>';
                }
                $hasil .= '</div>';
            }
            $hasil .= '
        </div>
        <div class="card-footer">
        <div class="row justify-content-between">
        <div class="col-md-6 col-lg-6">
        Total Rp. ' . number_format($t->total) . '
        </div>
        <div class="col-md-6 col-lg-6  text-right">';
            if (!empty($t->resi) && $t->status < 6) {
                $hasil .= '<a href="/cekresi/' . $t->kurir . '/' . $t->resi . '" class="btn btn-info ">Lacak</a>&nbsp;';
            }
            if ($t->status == 5) {
                $hasil .= '<a href="/order-selesai/' . encrypt($t->id) . '" class="btn btn-success">Order Selesai</a>';
                $hasil .= '&nbsp;<a href="/komplain/order/' . encrypt($t->id) . '" class="btn btn-danger">Komplain</a>';
            }
            if ($t->status == 0) {
                $hasil .= '<a href="/konfirmasi-pembayaran/' . encrypt($t->id) . '" class="btn btn-success">Sudah ditransfer</a>';
            }
            $hasil .= '</div>
        </div>
        </div>
    </div>
   ';
        }
        $hasil .= '</div></div>';
        if ($jml < 1) {

            $hasil = '<div class="alert alert-danger text-center">Tidak Ditemukan Transaksi ' . $a_status[$status] . ' </div>';
        }
        return $hasil;
    }
}

function count_transaction_branch($status)
{
    $branch_id = session('branch-session')->branch_id;
    $count = App\Transaction::where('status', '=', $status)
        ->where('processed_by', $branch_id)
        ->count();
    return $count;
}

function transaction_branch($status)
{
    $branch_id = session('branch-session')->branch_id;
    $trans = App\Transaction::with(['detil', 'user', 'address'])
        ->where('status', $status)
        ->where('processed_by', $branch_id)

        ->orderBy('id', 'Desc')->get();
    $hasil = '<div class="row">
    <div class="col-12">';
    $a_status = ['Belum Dibayar', 'Sudah Dibayar', 'Sudah Diproses', 'Sudah Dikemas', 'Sudah Dikirim', 'Sudah Sampai',  'Sudah Selesai', '', '', '', ' Batal'];
    if (count($trans) > 0) {
        $hasil .= '<h4 class="text-center">Daftar transaksi ' . $a_status[$status] . '</h4>';
    }
    $hasil .= '<div class="row">
    <div class="col-12">';
    $jml = 0;
    foreach ($trans as $t) {
        $jml++;
        $hasil .= '<div class="card mt-2 mb-2">
                <div class="card-header bg-light p-3 pb-0 m-0">
                    <div class="row justify-content-between m-0 p-0 text-dark">
                        <div class="col-7 m-0 pl-2 pr-2 "><a href="/branch/detil-transaksi/' . $t->id_transaction . '" target="_blank">' . $t->id_transaction . '</a> / ' . $t->date_created . '</div> 
                        <div class="col-5 m-0 pl-2 pr-2 text-right ">' . $t->address->name . '</div> 
                    </div>
                </div>
            <div class="card-body pt-3 pb-0">
                <div class="row">';
        if ($t->detil != null) {

            foreach ($t->detil as $l) {
                if ($l->product) {

                    $hasil .= '<div class="col-3 col-md-1 mb-3">
                                <div class="text-center">
                                    <a href="/branch/detil-produk/' . $l->product->slug . '"><img src="' . asset($l->product->image) . '" class="img-fluid" alt="" border=0 style="max-height: 120px !important;"></a>
                                </div>
                            </div>
                            <div class="col-9 col-md-11 mb-3">
                                <p><a href="/branch/detil-produk/' . $l->product->slug . '">' . $l->product->nama . '<br>Rp.' . number_format($l->product->harga) . '<br>' . number_format($l->qty) . ' ' . $l->product->satuan . ' </a></p>
                                
                            </div></a>';
                }
            }
        }
        $hasil .= '</div>';
        if (!empty($t->kurir)) {
            $hasil .=
                ' <hr class="p-0 m-0">
            <div class="row justify-content-between pt-2 pb-2">
            <div class="col-6">
           ';
            if (!empty($t->penerima)) {
                $hasil .= 'Pesanan sudah diterima ' . $t->penerima;
            } else {
                $hasil .= 'Kurir : ' . strtoupper($t->kurir) . ', Estimasi Kedatangan ' . $t->etd . ' Hari';
            }
            $hasil .= '</div>';

            if (!empty($t->resi)) {
                $hasil .= '<div class="col-6 text-right">
            No Resi : <a href="/branch/cekresi/' . $t->kurir . '/' . $t->resi . '" class="text-success" >' . $t->resi . '</a>
            </div>';
            }
            $hasil .= '</div>';
        }
        $hasil .= '
        </div>
        <div class="card-footer">
        <div class="row justify-content-between">
        <div class="col-6">
        Total Rp. ' . number_format($t->total) . '
        </div>
        <div class="col-6 text-right">';
        if (!empty($t->resi) && $t->status < 6) {
            $hasil .= '<a href="/branch/cekresi/' . $t->kurir . '/' . $t->resi . '" class="btn btn-success mr-2">Lacak</a>';
        }
        if ($t->status == 0) {
            $tgl_mutasi = substr($t->date_created, 0, 10);
            $hasil .= '';
        }
        if ($t->status == 1) {
            $hasil .= '<a href="/branch/transaction/proses/' . $t->id . '" class="btn btn-success">Order Diproses</a>';
        }
        if ($t->status == 2) {
            $hasil .= '<a href="/branch/transaction/kemas/' . $t->id . '" class="btn btn-success">Order Dikemas</a>';
        }
        if ($t->status == 3) {
            $hasil .= '<a href="/branch/transaction/kirim/' . $t->id . '" class="btn btn-success">Order Dikirim</a>';
            //    $hasil .= '<a href="#" onclick="kirim({{$t->id}})" class="btn btn-success">Sudah Dikirim</a>';
        }
        if ($t->status == 5) {
            $hasil .= '<a href="/branch/transaction/selesai/' . $t->id . '" class="ml-3 btn btn-success">Order Selesai</a>';
        }
        $hasil .= '</div>
        </div>
        </div>
    </div>
   ';
    }
    $hasil .= '</div></div></div></div>';
    if ($jml < 1) {

        //        $hasil = '<div class="col-12 alert alert-danger text-center">Tidak Ditemukan Transaksi ' . $a_status[$status] . ' </div>';
    }
    return $hasil;
}

function count_transaction_backend($status)
{
    $count = App\Transaction::where('status', '=', $status)
        ->count();
    return $count;
}


function transaction_backend($status)
{
    $trans = App\Transaction::with(['detil', 'user', 'address'])
        ->where('status', $status)
        ->orderBy('id', 'Desc')->get();
    $hasil = '<div class="row">
    <div class="col-12">';
    $a_status = ['Belum Dibayar', 'Sudah Dibayar', 'Sudah Diproses', 'Sudah Dikemas', 'Sudah Dikirim', 'Sudah Selesai', '', '', '', ' Batal'];
    if (count($trans) > 0) {
        $hasil .= '<h4 class="text-center">Daftar transaksi ' . $a_status[$status] . '</h4>';
    }
    $hasil .= '<div class="row">
    <div class="col-12">';
    $jml = 0;
    foreach ($trans as $t) {
        $jml++;
        $hasil .= '<div class="card mt-2 mb-2">
                <div class="card-header bg-light p-3 pb-0 m-0">
                    <div class="row justify-content-between m-0 p-0 text-dark">
                        <div class="col-7 m-0 pl-2 pr-2 "><a href="/backend/detil-transaksi/' . $t->id_transaction . '" target="_blank">' . $t->id_transaction . '</a> / ' . $t->date_created . '</div> 
                        <div class="col-5 m-0 pl-2 pr-2 text-right ">' . $t->address->name;
        if (!empty($t->processed_by)) {
            $hasil .= ' / <span class="text-danger">' . $t->processed_by . '</span>';
        }

        $hasil .= '</div> 
                    </div>
                </div>
            <div class="card-body pt-3 pb-0">
                <div class="row">
                ';
        if ($t->detil != null) {

            foreach ($t->detil as $l) {
                if ($l->product) {

                    $hasil .= '<div class="col-3 col-md-1 mb-3">
                                <div class="text-center">
                                    <a href="/backend/detil-produk/' . $l->product->slug . '"><img src="' . asset($l->product->image) . '" class="img-fluid" alt="" border=0 style="max-height: 120px !important;"></a>
                                </div>
                            </div>
                            <div class="col-9 col-md-11 mb-3">
                                <p><a href="/backend/detil-produk/' . $l->product->slug . '">' . $l->product->nama . '<br>Rp.' . number_format($l->product->harga) . '<br>' . number_format($l->qty) . ' ' . $l->product->satuan . ' </a></p>
                                
                            </div></a>';
                }
            }
        }
        $hasil .= '</div>';
        if (!empty($t->kurir)) {
            $hasil .=
                ' <hr class="p-0 m-0">
            <div class="row justify-content-between pt-2 pb-2">
            <div class="col-6">
           ';
            if (!empty($t->penerima)) {
                $hasil .= 'Pesanan sudah diterima ' . $t->penerima;
            } else {
                $hasil .= 'Kurir : ' . strtoupper($t->kurir) . ', Estimasi Kedatangan ' . $t->etd . ' Hari';
            }
            $hasil .= '</div>';
            if (!empty($t->resi)) {
                $hasil .= '<div class="col-6 text-right">
            No Resi : <a href="/backend/cekresi/' . $t->kurir . '/' . $t->resi . '" class="text-success" target="_blank">' . $t->resi . '</a>
            </div>';
            }
            $hasil .= '</div>';
        }
        $hasil .= '
        </div>
        <div class="card-footer">
        <div class="row justify-content-between">
        <div class="col-4">
        Total Rp. ' . number_format($t->total) . '
        </div>
        <div class="col-8  text-right">';
        if (!empty($t->resi) && $t->status < 6) {
            $hasil .= '<a href="/backend/cekresi/' . $t->kurir . '/' . $t->resi . '" class="btn btn-success">Lacak</a>';
        }
        if ($t->status == 0) {
            $tgl_mutasi = substr($t->date_created, 0, 10);
            $hasil .= '<div class="row float-right"><a href="/backend/moota/cek-mutasi/' . $tgl_mutasi . '" target="_blank" class="btn btn-success btn-sm mr-1 mb-1">Cek Mutasi</a>
            <a href="/backend/transaction/confirmasi-pembayaran/' . encrypt($t->id) . '" class="btn btn-warning btn-sm mr-1 mb-1">Cek Pembayaran </a>
            <a href="/backend/transaction/bayar/' . $t->id . '" class="btn btn-danger btn-sm mb-1">Sudah Dibayar</a>';
            if ($t->bukti_pembayaran <> null) {
                $hasil .= '&nbsp;<a href="#' . $t->id . '" onclick="bukti_bayar(' . $t->id . ')" class="btn btn-info btn-sm mr-1  mb-1">Bukti Transfer</a>';
            }
            $hasil .= '
            </div>
            
            ';
        }
        if ($t->status == 1) {
            $hasil .= '<a href="/backend/transaction/proses/' . $t->id . '" class="btn btn-success">Order Diproses</a>';
        }
        if ($t->status == 2) {
            $hasil .= '<a href="/backend/transaction/kemas/' . $t->id . '" class="btn btn-success">Order Dikemas</a>';
        }
        if ($t->status == 3) {
            $hasil .= '<a href="/backend/transaction/kirim/' . $t->id . '" class="btn btn-success">Order Dikirim</a>';
            //    $hasil .= '<a href="#" onclick="kirim({{$t->id}})" class="btn btn-success">Sudah Dikirim</a>';
        }
        if ($t->status == 5) {
            $hasil .= '<a href="/backend/transaction/selesai/' . $t->id . '" class="ml-3 btn btn-success">Order Selesai</a>';
        }
        $hasil .= '</div>
        </div>
        </div>
    </div>
   ';
    }
    $hasil .= '</div></div></div></div>';
    if ($jml < 1) {

        // $hasil = '<div class="col-12 alert alert-danger text-center">Tidak Ditemukan Transaksi ' . $a_status[$status] . ' </div>';
    }
    return $hasil;
}

function get_refferal($id)
{
    // try {
    $company = App\Company::first();
    if (session('company') == !null) {
        $company = Company::first();
        session(['company' => $company]);
        $cookie_name = $company->nama;
    } else {
        $cookie_name = env('STORE_NAME');
    }

    if (!empty($id)) {
        $apiKey = md5(env('KEY_KATALOG_PRODUK') . $id);
        $link = env('PROFILE_REFFERAL_LINK') . '/' . $id;
        $response = Http::withHeaders([
            'accept' => 'application/json'
        ])->withToken($apiKey)
            ->get($link, ['token' => $apiKey])->json();
        if ($response['status'] == 200) {
            $data = $response['data'];
            session(['data_refferal' => json_encode($data)]);
            $cookie_name = env('STORE_NAME');
            $cookie_value = json_encode($data);
            //setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 
            setcookie($cookie_name, $cookie_value, 2147483647, "/"); // 86400 = 1 


        } else {
            $id = "supermitra";
            $apiKey = md5(env('KEY_KATALOG_PRODUK') . $id);
            $link = env('PROFILE_REFFERAL_LINK') . '/' . $id;
            $response = Http::withHeaders([
                'accept' => 'application/json'
            ])->withToken($apiKey)
                ->get($link)->json();
            if ($response['status'] == 200) {
                $data = $response['data'];
                session(['data_refferal' => json_encode($data)]);
                $cookie_name = env('STORE_NAME');
                $cookie_value = json_encode($data);
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 
            }
        }
        return $response['data'];
    }
    /* } catch (Exception $e) {
        echo '<div class="alert alert-danger text-center" style="margin:30px auto;text-align:center">
            Browser Anda tidak mendukung Cookie</div>';
    }*/
}

function log_transaction($data)
{

    try {
        App\LogTransaction::create([
            'id_transaction' => $data['id_transaction'],
            'trans_id' => $data['trans_id'],
            'status' => $data['status'],
            'description' => $data['description'],
            'created_by' => $data['created_by'],
            'detail' => $data['detail'],
            'menu' => $data['menu'],

        ]);
    } catch (Exception $e) {
        return redirect()->back()->with(['message' => 'Log Transaction failed to save' . $e->getMessage(), 'color' => 'alert-danger'])->withInput($data);
    }
}
function update_status_transaksi_branch($id, $status, $resi = null, $user = null, $menu = null, $detail = null, $stokis = null)
{
    $trans = App\Transaction::find($id);
    if ($user == null) {
        $user = session('branch-session')->branch_id;
    }
    if ($menu == null) {
        $menu = "Branch";
    }
    if ($stokis == null) {
        $stokis = session('branch-session')->branch_id;
    }

    if ($status == 4) {

        if ($resi != null) {
            $detail = $resi;
        }
        $hsl = $trans->update([
            'status' => $status,
            'resi' => $resi
        ]);
    } else {
        if ($status == 2) {
            $update_stok = update_stok_stokis($stokis, $trans->id_transaction);
            if ($update_stok) {
                $hsl = $trans->update([
                    'status' => $status,
                ]);
            } else {
                $hsl = false;
            }
        } else {
            $hsl = $trans->update([
                'status' => $status,
            ]);
        }
    }

    $ket_status = array('Menunggu Pembayaran', 'Pembayaran Terverifikasi', 'Pesanan Sedang Diproses', 'Pesanan Sedang Dikemas', 'Pesanan Sudah dikirim dengan No Resi ' . $resi, 'Pesanan Telah diterima', '', '', '', 'Pesanan Dibatalkan');
    $log_transaction = [
        'id_transaction' => $trans->id_transaction,
        'trans_id' => $trans->id,
        'status' => $status,
        'description' => $ket_status[$status],
        'created_by' => $user,
        'menu' => $menu,
        'detail' => $detail
    ];
    if ($status == 2) {

        if ($update_stok) {
            $log = log_transaction($log_transaction);
        }
    } else {
        $log = log_transaction($log_transaction);
    }


    return $hsl;
}

function update_stok_stokis($stokis, $trans_id)
{

    $no_transaksi = $trans_id;
    $detil = DB::select('SELECT * FROM `list_transaction`  inner join product  on list_transaction.id_barang=product.id where list_transaction.id_transaction=?', [$no_transaksi]);
    $data = (['status' => false, 'message' => 'Transaksi tidak ditemukan', 'alert' => 'danger']);

    if (count($data) > 0) {
        $trans = App\Transaction::with('user')->where('id_transaction', $no_transaksi)->first();
        $bank = App\Bank::where('no_akun', $trans->no_rek)->get();
        if ($trans) {
            $address = App\Contact::with('kota', 'kecamatan')->find($trans->id_address);
            $data = ([
                'status' => true,
                'transaction' => $trans,
                'detail_transaction' => $detil,
                'address' => $address,
                'bank' => $bank

            ]);
        }
    }
    $token = md5($stokis);

    $url = env('URL_STOKIS') . "/mod/online_store/update_stock.php";
    //$url = env('URL_STOKIS') . "/mod/online_store/update_stock.php?token=" . $token . "&id=" . $trans_id . "&st=" . $stokis;

    $post = [
        'token' => $token,
        'id' => $trans_id,
        'st' => $stokis,
        'data' => $data
    ];

    /*
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url, // your preferred link
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_TIMEOUT => 30000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS, $post,
        
    ));
    $response = curl_exec($curl);

    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        print_r(json_decode($response));
    }
    */
    //$response = Http::get('http://google.com');
    // $url = "https://shadnetwork.com/mitsal/mod/online_store/test.php?st=SLS07";
    $response = Http::post($url, [$post]);
    $result = $response->body();
    return $result;
}
function update_status_transaksi($id, $status, $resi = null, $user = null, $menu = null, $detail = null)
{
    $trans = App\Transaction::find($id);

    $user = session('backend-session')->username;
    $menu = "Backend";

    if ($status == 4) {

        if ($resi != null) {
            $detail = $resi;
        }
        $hsl = $trans->update([
            'status' => $status,
            'resi' => $resi
        ]);
    } else {


        if ($status == 2) {
            $branch = Branch::where('main_office', 1)->first();
            $branch_id = $branch->branch_id;
            $update_stok = update_stok_stokis($branch_id, $trans->id_transaction);
            if ($update_stok) {

                $hsl = $trans->update([
                    'status' => $status,
                    'processed_by' => $branch_id,
                ]);
            } else {
                $hsl = false;
            }
        } else {
            $hsl = $trans->update([
                'status' => $status,
            ]);
        }
    }

    $ket_status = array('Menunggu Pembayaran', 'Pembayaran Terverifikasi', 'Pesanan Sedang Diproses', 'Pesanan Sedang Dikemas', 'Pesanan Sudah dikirim dengan No Resi ' . $resi, 'Pesanan Telah diterima', '', '', '', 'Pesanan Dibatalkan');
    $log_transaction = [
        'id_transaction' => $trans->id_transaction,
        'trans_id' => $trans->id,
        'status' => $status,
        'description' => $ket_status[$status],
        'created_by' => $user,
        'menu' => $menu,
        'detail' => $detail
    ];
    log_transaction($log_transaction);
    return $hsl;
}
function save_event_log_admin($data)
{
    DB::insert('insert into event_log ( user_id,path,refferal,ip,description) values (?, ?,?,?,?)', $data);
}


function only_month($tgl)
{
    $bln = substr($tgl, 5, 2);
    $bulan = array(
        "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
        "Agustus", "September", "Oktober", "Nopember", "Desember"
    );
    $sekarang = $bulan[(int)($bln) - 1];
    return $sekarang;
}
function only_day($tgl)
{
    $hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum`at", "Sabtu");
    $thn = substr($tgl, 0, 4);
    $bln = substr($tgl, 5, 2);
    $tg = substr($tgl, 8, 2);

    $hr = date("w", mktime(0, 0, 0, $bln, $tg, $thn));
    $sekarang = $hari[$hr];
    return $sekarang;
}
function only_date($tgl)
{
    $tg = substr($tgl, 8, 2);
    $sekarang = $tg;
    return $sekarang;
}
function only_years($tgl)
{
    $thn = substr($tgl, 0, 4);
    $sekarang = $thn;
    return $sekarang;
}
function convertTgl($tgl, $tanda)
{
    $a_tgl = explode($tanda, $tgl);
    $tanggal = $a_tgl[2] . "-" . $a_tgl[1] . "-" . $a_tgl[0];
    return $tanggal;
}
function convert_tgl($tgl)
{
    $hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum`at", "Sabtu");
    $thn = substr($tgl, 0, 4);
    $bln = substr($tgl, 5, 2);
    $tg = substr($tgl, 8, 2);
    $jam = substr($tgl, 11, 8);
    $hr = date("w", mktime(0, 0, 0, $bln, $tg, $thn));
    $bulan = array(
        "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
        "Agustus", "September", "Oktober", "Nopember", "Desember"
    );
    $sekarang = $hari[$hr] . ", " . $tg . " " . $bulan[(int)($bln) - 1] . " " . $thn . " " . $jam;
    return $sekarang;
}

function convert_tgl1($tgl)
{
    $thn = substr($tgl, 0, 4);
    $bln = substr($tgl, 5, 2);
    $tg = substr($tgl, 8, 2);
    $jam = substr($tgl, 11, 8);
    $hr = date("w", mktime(0, 0, 0, $bln, $tg, $thn));
    $sekarang = $tg . "-" . $bln . "-" . $thn;
    return $sekarang;
}

function convert_tgl2($tgl)
{
    $arr_tg = explode(" ", $tgl);
    $arr_tg1 = explode("-", $arr_tg[0]);
    $thn = $arr_tg1[0];
    $bln = $arr_tg1[1];
    $tg = $arr_tg1[2];
    $jam = $arr_tg[1];
    $hr = date("w");
    $sekarang = hari($hr) . ", " . $tg . "-" . $bln . "-" . $thn . " " . $jam;
    return $sekarang;
}

function hari($hr)
{
    $array_hari = array("", "Senin", "Selasa", "Rabu", "Kamis", "Jum`at", "Sabtu", "Minggu");
    return $array_hari[$hr];
}

function bulan($bl)
{
    $bl = (int) $bl;
    $array_bulan = array("", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des");
    return $array_bulan[$bl];
}
function bulan1($bl)
{
    $bl = (int) $bl;
    $array_bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    return $array_bulan[$bl];
}

function tglsekarang()
{
    $tglskr = hari(date('N')) . " " . date('d') . "-" . bulan((int)date('m')) . "-" . date('Y');
    return $tglskr;
}

function cek_pembayaran_by_moota($amount, $tgl)
{

    $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJucWllNHN3OGxsdyIsImp0aSI6IjdjM2E1ZGY3OTM4NGZiZDliYjZhMjhiZmM3NTA4ZTg1ODJhOTY1MDBlODk2MzkxZWE0YjA0OWUxMWNkMjM2Y2JhMjlmZThjZjMxZmVhZTRjIiwiaWF0IjoxNjU4Mjc1NjQxLjU3OTIyNCwibmJmIjoxNjU4Mjc1NjQxLjU3OTIyNywiZXhwIjoxNjg5ODExNjQxLjU3NjI2Niwic3ViIjoiMjI0OTkiLCJzY29wZXMiOlsiYXBpIiwidXNlciIsInVzZXJfcmVhZCIsImJhbmsiLCJiYW5rX3JlYWQiLCJtdXRhdGlvbiIsIm11dGF0aW9uX3JlYWQiXX0.QONnJdHEwSXbHI1RZo2UmLZl5CXvHYnpVmwywpd3ihxOj3JmmBx08_AkTS8g7Z4SXI1_nlZh2-KN7_cg3CNNXJM6-Gcb6VWyIWpmmmpMjUtlqOjJRtTyO-9IWrEw0jC4QPQTGg4P4OEHiJP5KvJ1rDyJWY6CRiRPTCPV4pWN2i3P35vc_CU3Ji6noi3339bWfVbo2CRYMipjb10lrzNGmXmER3iMtesLqDd8DxlzNtSUASIx92psnOExoPcgyicCZxPeqqJShi-Jb9xDTnpJ22jkn7Fb_3Y0e3EcPBABXwYZghPXB15sU6Mu6sBal9EwCKVxQKZMJJluYsG4JoleZedUX4k96UzMGo9CC53B8bUrGNecgtwypxcEZK5yato4UdudiwyLMdh_3BCFIcbEKU2HQhu7CQpF1Nifyhl7EbJu5oQ2VR0yJ9E6DupCUKYySllCNUKruFfOnhEj45assSbSmPNDaZgDW5cFdnPobQIhP2yHdywAE_zID0qBWu8Vt71qYOTmkVqYYkz8fPVRfAQTZ1dpzCTfq5b6t6F8D4ROVxt0c0RQW8YsDeFwwk-TNL4CI8Guq-jXiaA3g7XsNrIEDbCHH9qG6_1nT3I8XSdyJoOK8Ct55k_fdmdtc2P-Ks4WPZAKhbLeBnF-UX9d-rBo5r7z6GPcYEP2fGu0CbI";
    $url = "https://app.moota.co/api/v2/mutation";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //Set your auth headers
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
    ));
    // get stringified data/output. See CURLOPT_RETURNTRANSFER
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result);
    $data = $result->data;
    foreach ($data as $dt) {
        if (substr($dt->date, 0, 10) >= $tgl) {
            if ($dt->amount == $amount) {
                $result = ([
                    'status' => 200,
                    'data' => $dt,
                ]);
                return $result;
            }
        }
    }
    $result = ([
        'status' => '404',
        'message' => 'Data not found'
    ]);
    return $result;
}
