<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Contact;
use App\ListTransaction;
use App\Log_Processed_By;
use App\Users;
use Illuminate\Http\Request;
use App\Transaction;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{
    public function customer_for_refferal(Request $req)
    {
        $reff = $req->reff;
        $tg1 = $req->tg1;
        $tg2 = $req->tg2;
        // return response()->json(['tg1' => $tg1, 'tg2' => $tg2]);
        $token_remote = $req->token;
        //$token = bcrypt(env('TOKEN_TRANSACTION') . $reff);
        $key = env('KEY_KATALOG_PRODUK');
        $token = md5($key . $reff);
        if ($token == $token_remote) {
            if (!empty($tg1) && !empty($tg2)) {
                $trans = DB::select('select id, name, email, phone, refferal, refferal_id, left(created_at,10) as tgl_daftar, photo from users where refferal = ? and left(created_at,10)>=? and left(created_at,10)<=? order by id desc', [$reff, $tg1, $tg2]);
            } else {
                $trans = DB::select('select id, name, email, phone, refferal, refferal_id, left(created_at,10) as tgl_daftar, photo from users where refferal = ? order by id desc', [$reff]);
            }
            $record = count($trans);

            if ($record > 0) {
                return response()->json(['status' => 200, 'record' => $record, 'data' => $trans]);
            } else {
                return response()->json(['status' => 404, 'message' => 'Data Not Found !!!']);
            }
        } else {
            return response()->json(['status' => 403, 'message' => 'Access Denied !!!']);
        }
    }
    public function transaction_for_refferal(Request $req)
    {
        $inv = $req->inv;
        $reff = $req->reff;
        $token_remote = $req->token;
        //$token = bcrypt(env('TOKEN_TRANSACTION') . $reff);
        $key = env('KEY_KATALOG_PRODUK');
        $token = md5($key . $reff);
        if ($token == $token_remote) {
            if (!empty($inv)) {
                $trans = DB::table('transaction')
                    ->join('users', 'transaction.id_user', '=', 'users.id')
                    ->select('transaction.*', 'users.username', 'users.name')
                    ->where('users.refferal', $reff)
                    ->where('transaction.id_transaction', $inv)
                    ->get();
            } else {

                $trans = DB::table('transaction')
                    ->join('users', 'transaction.id_user', '=', 'users.id')
                    ->select('transaction.*',  'users.username', 'users.name')
                    ->where('users.refferal', $reff)
                    ->get();
            }
            // $trans = DB::select('select * from users where active = ?', [1])Transaction::where('refferal', $reff)->get(['id', 'name', 'email', 'phone', 'refferal', 'refferal_id']);
            $record = $trans->count();
            if ($record > 0) {
                return response()->json(['status' => 200, 'record' => $record, 'data' => $trans]);
            } else {
                return response()->json(['status' => 404, 'message' => 'Data Not Found !!!']);
            }
        } else {
            return response()->json(['status' => 403, 'message' => 'Access Denied !!!']);
        }
    }
    public function status_transaction_for_refferal(Request $req)
    {
        $reff = $req->reff;
        $status = $req->status;
        $token_remote = $req->token;
        //$token = bcrypt(env('TOKEN_TRANSACTION') . $reff);
        $key = env('KEY_KATALOG_PRODUK');
        $token = md5($key . $reff);
        if ($token == $token_remote) {
            $trans = DB::table('transaction')
                ->join('users', 'transaction.id_user', '=', 'users.id')
                ->select('transaction.*',  'users.username', 'users.name')
                ->where('users.refferal', $reff)
                ->where('transaction.status', $status)
                ->get();
            // $trans = DB::select('select * from users where active = ?', [1])Transaction::where('refferal', $reff)->get(['id', 'name', 'email', 'phone', 'refferal', 'refferal_id']);
            $record = $trans->count();
            if ($record > 0) {
                return response()->json(['status' => 200, 'record' => $record, 'data' => $trans]);
            } else {
                return response()->json(['status' => 404, 'message' => 'Data Not Found !!!']);
            }
        } else {
            return response()->json(['status' => 403, 'message' => 'Access Denied !!!']);
        }
    }
    public function detil_transaksi(Request $req)
    {
        $id_transaction = $req->trans_id;
        $token_remote = $req->token;
        $stokis = $req->stokis;
        $token_remote = $req->token;
        //$token = bcrypt(env('TOKEN_TRANSACTION') . $reff);
        $key = env('KEY_KATALOG_PRODUK');
        $token = md5($key . $stokis);
        if ($token == $token_remote) {

            $detil = DB::select('SELECT list_transaction.*,product.nama,product.harga, product.satuan, product.image FROM `list_transaction`  inner join product  on list_transaction.id_barang=product.id where list_transaction.id_transaction=?', [$id_transaction]);

            if (count($detil) > 0) {
                $trans = Transaction::with('user')->where('id_transaction', $id_transaction)->first();
                $bank = Bank::where('no_akun', $trans->no_rek)->get();
                if ($trans) {
                    $address = Contact::with('kota', 'kecamatan')->find($trans->id_address);
                }
            }
            // $transaction = Transaction::where('id_transaction', $id_transaction);
            //$list_transaction = ListTransaction::where('id_transaction', $id_transaction);

            /*$trans = DB::table('list_transaction')
                ->join('users', 'list_transaction.id_user', '=', 'users.id')
                ->join('product', 'list_transaction.id_barang', '=', 'product.id')
                ->join('transaction', 'transaction.id_transaction', '=', 'list_transaction.id_transaction')
                ->join('contact', 'contact.id', '=', 'transaction.id_address')
                ->select('list_transaction.*',  'product.nama', 'product.harga', 'product.satuan', 'product.image', 'contact.*')
                ->where('list_transaction.id_transaction', $id_transaction)
                ->get();*/
            // $trans = DB::select('select * from users where active = ?', [1])Transaction::where('refferal', $reff)->get(['id', 'name', 'email', 'phone', 'refferal', 'refferal_id']);
            $record = $trans->count();
            $data['detil'] = $detil;
            $data['trans'] = $trans;
            $data['bank'] = $bank;
            $data['address'] = $address;
            //$data = $trans;
            if ($record > 0) {
                return response()->json(['status' => 200, 'record' => $record, 'data' => $data]);
            } else {
                return response()->json(['status' => 404, 'message' => 'Data Not Found !!!']);
            }
        } else {
            return response()->json(['status' => 403, 'message' => 'Access Denied !!!']);
        }
    }
    public function detil_transaction_for_refferal(Request $req)
    {
        $reff = $req->reff;
        $id_transaction = $req->inv;
        $token_remote = $req->token;
        //$token = bcrypt(env('TOKEN_TRANSACTION') . $reff);
        $key = env('KEY_KATALOG_PRODUK');
        $token = md5($key . $reff);
        if ($token == $token_remote) {
            $trans = DB::table('list_transaction')
                ->join('users', 'list_transaction.id_user', '=', 'users.id')
                ->join('product', 'list_transaction.id_barang', '=', 'product.id')
                ->select('list_transaction.*',  'product.nama', 'product.harga', 'product.satuan', 'product.image')
                ->where('users.refferal', $reff)
                ->where('list_transaction.id_transaction', $id_transaction)
                ->get();
            // $trans = DB::select('select * from users where active = ?', [1])Transaction::where('refferal', $reff)->get(['id', 'name', 'email', 'phone', 'refferal', 'refferal_id']);
            $record = $trans->count();
            if ($record > 0) {
                return response()->json(['status' => 200, 'record' => $record, 'data' => $trans]);
            } else {
                return response()->json(['status' => 404, 'message' => 'Data Not Found !!!']);
            }
        } else {
            return response()->json(['status' => 403, 'message' => 'Access Denied !!!']);
        }
    }
    public function bank_for_refferal(Request $req)
    {
        $reff = $req->reff;
        $id_transaction = $req->inv;
        $token_remote = $req->token;
        //$token = bcrypt(env('TOKEN_TRANSACTION') . $reff);
        $key = env('KEY_KATALOG_PRODUK');
        $token = md5($key . $reff);
        if ($token == $token_remote) {

            $no_akun = $req->id;
            if (!empty($no_akun)) {
                $bank = Bank::where('no_akun', $no_akun)->get();
            } else {
                $bank = Bank::get();
            }

            $record = $bank->count();
            if ($record > 0) {
                return response()->json(['status' => 200, 'record' => $record, 'data' => $bank]);
            } else {
                return response()->json(['status' => 404, 'message' => 'Data Not Found !!!']);
            }
        } else {
            return response()->json(['status' => 403, 'message' => 'Access Denied !!!']);
        }
    }
    public function status_transaction(Request $req)
    {
        $stokis = $req->stokis;
        $status = $req->status;
        $token_remote = $req->token;
        //$token = bcrypt(env('TOKEN_TRANSACTION') . $reff);
        $key = env('KEY_KATALOG_PRODUK');
        $token = md5($key . $stokis);
        if ($token == substr($token_remote, 0, strlen($token))) {
            $trans = DB::table('transaction')
                ->join('users', 'transaction.id_user', '=', 'users.id')
                ->select('transaction.*',  'users.username', 'users.name')
                ->where('transaction.status', $status)
                ->where('processed_by', $stokis)
                ->get();

            // $trans = DB::select('select * from users where active = ?', [1])Transaction::where('refferal', $reff)->get(['id', 'name', 'email', 'phone', 'refferal', 'refferal_id']);
            $record = $trans->count();
            if ($record > 0) {
                return response()->json(['status' => 200, 'record' => $record, 'data' => $trans]);
            } else {
                return response()->json(['status' => 404, 'message' => 'Data Not Found !!!']);
            }
        } else {
            return response()->json(['status' => 403, 'message' => 'Access Denied !!!']);
        }
    }


    public function update_status(Request $req)
    {
        $token_remote = $req->token;

        $stokis = $req->stokis;
        $status = $req->status;
        $token_remote = $req->token;
        $resi = $req->resi;
        $detail = $req->detail;
        $hsl = false;


        //$token = bcrypt(env('TOKEN_TRANSACTION') . $reff);
        $key = env('KEY_KATALOG_PRODUK');
        $token = md5($key . $stokis);
        if ($token == substr($token_remote, 0, strlen($token))) {

            $trans = Transaction::where('id', $req->id)
                ->where('processed_by', $stokis)->first();
            if ($trans) {
                if ($trans->status > 0) {

                    $user = $req->user;
                    $menu = $req->menu;

                    if ($status == 4) {

                        if ($resi != null) {
                            $detail = $resi;
                        }
                        $hsl = $trans->update([
                            'status' => $status,
                            'resi' => $resi
                        ]);
                    } else {


                        $hsl = $trans->update([
                            'status' => $status,
                        ]);
                    }

                    $ket_status = array('Menunggu Pembayaran', 'Pembayaran Terverifikasi', 'Pesanan Sedang Diproses', 'Pesanan Sedang Dikemas', 'Pesanan Sudah dikirim dengan No Resi ' . $resi, 'Pesanan Telah diterima', '', '', '', 'Pesanan Dibatalkan');
                    if ($hsl) {
                        $log_transaction = [
                            'id_transaction' => $trans->id_transaction,
                            'trans_id' => $trans->id,
                            'status' => $status,
                            'description' => $ket_status[$status],
                            'created_by' => $user,
                            'menu' => $menu,
                            'detail' => $detail
                        ];

                        $log = log_transaction($log_transaction);
                    }
                }
            }
            echo $hsl;
        } else {
            echo $hsl;
            //return response()->json(['status' => 403, 'message' => 'Access Denied !!!']);
        }
    }
}
