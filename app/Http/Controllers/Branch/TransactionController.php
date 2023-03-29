<?php

namespace App\Http\Controllers\Branch;

use Illuminate\Http\Request;
use App\Transaction;

use App\Http\Controllers\Controller;
use App\Bank;
use App\Category;
use App\Contact;
use App\Product;
use App\Satuan;
use App\SubCategory;
use App\SubSubCategory;
use App\Users;
use Exception;
Use Alert;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function daftar_transaction()
    {
        try {
            $branch = session('branch-session')->branch_id;
            $data = DB::select(
                'select a.*,b.* from transaction a inner join users b on a.id_user =b.id  where  processed_by =? and status>0 order by date_created',
                [$branch]
            );
            $jenis = "all";
            $judul = "Daftar Transaksi Keseluruhan";
            return view('branch.pages.result_transaction_by_date', compact('data', 'judul', 'jenis'));
        } catch (Exception $e) {
        }
    }

    public function transaction_by_year()
    {
        return view('branch.pages.transaction_by_year');
    }
    public function process_transaction_by_year(Request $req)
    {
        $req->validate([
            'thn' => 'required',
        ]);
        try {
            $branch = session('branch-session')->branch_id;
            $thn = $req->thn;

            $data = DB::select(
                'select left(date_created,7) as periode, sum(sub_total) as tot_sub_total,
                sum(total) as tot_total, sum(total_ongkir) as tot_total_ongkir,sum(unix_code) as tot_unix_code
                , sum(total_bayar) as tot_total_bayar  from transaction   where left(date_created,4)=? and processed_by =? and status>0 
                group by periode order by periode',
                [$thn, $branch]
            );
            $judul = "Daftar Transaksi Per Tahun<br>Tahun $thn";
            $jenis = "perthn";
            return view('branch.pages.result_transaction_by_year', compact('data', 'judul', 'jenis'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function transaction_by_month()
    {
        return view('branch.pages.transaction_by_month');
    }
    public function process_transaction_by_month(Request $req)
    {
        $req->validate([
            'bln' => 'required', 'thn' => 'required',
        ]);
        try {
            $branch = session('branch-session')->branch_id;
            $pr = $req->thn . "-" . $req->bln;
            $pr1 = $req->bln . "-" . $req->thn;

            $data = DB::select(
                'select a.*,b.* from transaction a inner join users b on a.id_user =b.id  where left(date_created,7)=? and processed_by =? and status>0 order by date_created',
                [$pr, $branch]
            );
            $judul = "Daftar Transaksi Per Bulan<br>Periode $pr1";
            $jenis = "perbln";
            return view('branch.pages.result_transaction_by_date', compact('data', 'judul', 'jenis'));
        } catch (Exception $e) {
        }
    }
    public function transaction_by_date()
    {
        return view('branch.pages.transaction_by_date');
    }
    public function process_transaction_by_date(Request $req)
    {
        $req->validate([
            'tanggal' => 'required',
        ]);
        try {
            $branch = session('branch-session')->branch_id;
            $a_tgl = explode(" to ", $req->tanggal);
            $tgl1 = convertTgl($a_tgl[0], "-");
            $tgl2 = convertTgl($a_tgl[1], "-");
            $data = DB::select(
                'select a.*,b.* from transaction a inner join users b on a.id_user =b.id  where left(date_created,10)>=? and left(date_created,10)<=? and processed_by =? and status>0 order by date_created',
                [$tgl1, $tgl2, $branch]
            );
            $judul = "Daftar Transaksi Per Tanggal";
            $jenis = "pertgl";
            return view('branch.pages.result_transaction_by_date', compact('data', 'judul', 'jenis'));
        } catch (Exception $e) {
        }
    }

    public function produk()
    {
        $data = Product::with(['category', 'sub_category', 'sub_sub_category'])
            ->orderBy('id', 'desc')->get();

        $category = Category::all();
        $subcategory = SubCategory::all();
        $subsubcategory = SubSubCategory::all();
        $satuan = Satuan::all();
        return view('branch.pages.product', compact('data', 'category', 'subcategory', 'subsubcategory', 'satuan'));
    }

    public function detil_produk(Request $req)
    {
        $product = Product::where('slug', $req->slug)->first();

        return view("branch.pages.detilProduk", compact('product'));
    }
    public function detil_transaksi(Request $req)
    {
        $no_transaksi = $req->id;
        $data = DB::select('SELECT * FROM `list_transaction`  inner join product  on list_transaction.id_barang=product.id where list_transaction.id_transaction=?', [$no_transaksi]);

        if (count($data) > 0) {
            $trans = Transaction::where('id_transaction', $no_transaksi)->first();
            $bank = Bank::where('no_akun', $trans->no_rek)->get();
            if ($trans) {
                return view('branch.pages.detil-transaksi', compact('data', 'trans', 'no_transaksi', 'bank'));
            }
        }
    }

    public function proses(Request $req)
    {
        $hsl = update_status_transaksi_branch($req->id, 2, null, null, null, null, null);

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
        $hsl = update_status_transaksi_branch($req->id, 3);
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
        return view('branch.pages.kirim', compact('id'));
    }
    public function proses_kirim(Request $req)
    {
        $hsl = update_status_transaksi_branch($req->id, 4, $req->resi);
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
        $hsl = update_status_transaksi_branch($req->id, 6);
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
        $hsl = update_status_transaksi_branch($req->id, 7);
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
        $hsl = update_status_transaksi_branch($req->id, 9);
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
        $hsl = update_status_transaksi_branch($req->id, 1);
        if ($hsl) {
            Alert::success('Proses Bayar Transaksi Sukses');
            return redirect()->back();
        } else {
            Alert::error('Proses Bayar Transaksi gagal');
            return redirect()->back();
        }
    }
}
