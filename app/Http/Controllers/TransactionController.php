<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Bank;
use App\Contact;
use App\Users;
use Illuminate\Support\Facades\DB;
Use Alert;
class TransactionController extends Controller
{
    public function detil_transaksi(Request $req)
    {
        $no_transaksi = $req->id;
        $data = DB::select('SELECT * FROM `list_transaction`  inner join product  on list_transaction.id_barang=product.id where list_transaction.id_transaction=?', [$no_transaksi]);

        if (count($data) > 0) {
            $trans = Transaction::with('user')->where('id_transaction', $no_transaksi)->first();
            $bank = Bank::where('no_akun', $trans->no_rek)->get();
            if ($trans) {
                $address = Contact::with('kota', 'kecamatan')->find($trans->id_address);
                return view('pages.detil-transaksi', compact('data', 'trans', 'no_transaksi', 'bank', 'address'));
            }
        }
    }
    public function transaction(Request $req)
    {
        $no_transaksi = $req->id;
        $data = DB::select('SELECT * FROM `list_transaction`  inner join product  on list_transaction.id_barang=product.id where list_transaction.id_transaction=?', [$no_transaksi]);
        $result = (['status' => false, 'message' => 'Transaksi tidak ditemukan', 'alert' => 'danger']);

        if (count($data) > 0) {
            $trans = Transaction::with('user')->where('id_transaction', $no_transaksi)->first();
            $bank = Bank::where('no_akun', $trans->no_rek)->get();
            if ($trans) {
                $address = Contact::with('kota', 'kecamatan')->find($trans->id_address);
                $result = ([
                    'status' => true,
                    'transaction' => $trans,
                    'detail_transaction' => $data,
                    'address' => $address,
                    'bank' => $bank

                ]);
            }
        }
        return $result;
    }
    public function detil_transaksi_backend(Request $req)
    {
        $no_transaksi = $req->id;
        $data = DB::select('SELECT * FROM `list_transaction`  inner join product  on list_transaction.id_barang=product.id where list_transaction.id_transaction=?', [$no_transaksi]);

        if (count($data) > 0) {
            $trans = Transaction::where('id_transaction', $no_transaksi)->first();
            $bank = Bank::where('no_akun', $trans->no_rek)->get();
            if ($trans) {
                $address = Contact::with('kota', 'kecamatan')->find($trans->id_address);

                return view('backend.pages.detil-transaksi', compact('data', 'trans', 'no_transaksi', 'bank', 'address'));
            }
        }
    }

    public function proses(Request $req)
    {
        $hsl = update_status_transaksi($req->id, 2);
        if ($hsl) {
            Alert::success('Proses Transaksi Sukses');
            return redirect()->back();
        } else {
            Alert::error('Proses Transaksi gagal');
            return redirect()->back();
        }
    }
    public function kemas(Request $req)
    {
        $hsl = update_status_transaksi($req->id, 3);
        if ($hsl) {
            Alert::success('Proses kemas Transaksi Sukses');
            return redirect()->back();
        } else {
            Alert::error('Proses kemas Transaksi gagal');
            return redirect()->back();
        }
    }
    public function kirim(Request $req)
    {
        $id = $req->id;
        return view('backend.pages.kirim', compact('id'));
    }
    public function proses_kirim(Request $req)
    {
        $hsl = update_status_transaksi($req->id, 4, $req->resi);
        if ($hsl) {
            Alert::success('Proses kirim Transaksi Sukses');
            return redirect()->back();
        } else {
            Alert::error('Proses kirim Transaksi gagal');
            return redirect()->back();
        }
    }
    public function selesai(Request $req)
    {
        $hsl = update_status_transaksi($req->id, 6);
        if ($hsl) {
            Alert::success('Proses Transaksi selesai Sukses');
            return redirect()->back();
        } else {
            Alert::error('Proses Transaksi selesai gagal');
            return redirect()->back();
        }
    }
    public function komplain(Request $req)
    {
        $hsl = update_status_transaksi($req->id, 7);
        if ($hsl) {
            Alert::success('Proses Transaksi selesai Sukses');
            return redirect()->back();
        } else {
            Alert::error('Proses Transaksi selesai gagal');
            return redirect()->back();
        }
    }
    public function batal(Request $req)
    {
        $hsl = update_status_transaksi($req->id, 9);
        if ($hsl) {
            Alert::success('Proses Pembatalan Transaksi Sukses');
            return redirect()->back();
        } else {
            Alert::error('Proses Pembatalan Transaksi gagal');
            return redirect()->back();
        }
    }
    public function dibayar(Request $req)
    {
        $hsl = update_status_transaksi($req->id, 1);
        if ($hsl) {
            Alert::success('Proses Bayar Transaksi Sukses');
            return redirect()->back();
        } else {
            Alert::error('Proses Bayar Transaksi gagal');
            return redirect()->back();
        }
    }
    public function foto_bukti_pembayaran(Request $req)
    {
        $trans = Transaction::find($req->id);
        if ($trans) {
            $gambar = $trans->bukti_pembayaran;
        } else {
            $gambar = "";
        }
        return $gambar;
    }
}
