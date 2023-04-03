<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\Dumy;
use App\Payget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use Alert;

class CartController extends Controller
{
    public function index()
    {
        if (empty(session('user-session'))) {
            return redirect('/');
        }
        if (empty(session('user-session')->id)) {
            return redirect('/');
        }
        $countcart = Cart::where('id_user', session('user-session')->id)
            ->where('status', 1)->count();
        session(['countcart' => $countcart]);
        $data = Cart::with(['user', 'product'])->where('id_user', session('user-session')->id)
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
        /* $data = DB::table('product')
            ->join('cart', 'cart.id_barang', '=', 'product.id')
            ->select('product.*', 'product.id as pid', 'cart.id as cid', 'cart.qty', 'cart.id_user', 'cart.id_barang', 'cart.status')
            ->where('cart.id_user', session('user-session')->id)
            ->orderBy('cart.id', 'DESC')
            ->get();*/
        /* $dummy = DB::table('product')
            ->join('dummy', 'dummy.id_barang', '=', 'product.id')
            ->select('product.*', 'dummy.id', 'dummy.qty', 'dummy.id_user', 'dummy.id_barang', 'dummy.total')
            ->where('dummy.id_user', session('user-session')->id)
            ->orderBy('dummy.id', 'DESC')
            ->get();*/
        $diskon = 0;
        //$countbuy = Dumy::where('id_user', session('user-session')->id)->count();
        //$sum = Dumy::where('id_user', session('user-session')->id)->sum('total', 'qty');

        return view("pages.cart", compact('data', 'countbuy',  'sum', 'diskon'));
    }
    public function create(Request $req)
    {
        if (empty(session('user-session'))) {
            return redirect('/');
        }
        if (empty(session('user-session')->id)) {
            return redirect('/');
        }
        $barang = Product::where('id', $req->id_barang)->first();
        $validasi = Cart::where('id_user', session('user-session')->id)
            ->where('id_barang', $req->id_barang)->first();
        /*$a = session('user-session')->id . rand(2, 50) . date('d-m-Y');
        $b = str_replace("-", "", $a);
        $transaction = 'TR-' . str_replace(".", "-", $b);*/
        if ($validasi) {
            $tambah = $validasi->qty + $req->qty;
            $berat = $barang->berat * $tambah;
            $total = $barang->harga * $tambah;
            $hsl = Cart::where('id', $validasi->id)->update([
                'qty' => $tambah
            ]);
            if ($hsl) {
                Alert::success('Barang berhasil ditambah ke keranjang');
                return redirect('/cart');
            } else {
                Alert::error('Barang gagal ditambah ke keranjang');
                return redirect()->back();
            }
        } else {
            $hsl = Cart::create([
                'id_user' => session('user-session')->id,
                'id_barang' => $req->id_barang,
                'qty' => $req->qty,
                'status' => 1
            ]);
            if ($hsl) {
                Alert::toast('Barang berhasil ditambah ke keranjang', 'success');
                return redirect('/cart');
            } else {
                Alert::toast('Barang gagal ditambah ke keranjang', 'error');
                return redirect()->back();
            }
        }
    }
    public function delete(Request $req)
    {
        if (empty(session('user-session'))) {
            return redirect('/');
        }
        if (empty(session('user-session')->id)) {
            return redirect('/');
        }
        $hsl = Cart::find($req->id)->delete();
        if ($hsl) {
                           
            Alert::toast('Barang berhasil dihapus dari keranjang', 'success');
            return redirect()->back();
        } else {
            Alert::toast('Barang gagal dihapus dari keranjang', 'error');
            return redirect()->back();
        }
    }

    public function add_dummy($id_barang, $berat, $transaction)
    {
        $getcart = Cart::where('id_user', '=', session('user-session')->id)
            ->where('id_barang', '=', $id_barang)
            ->first();
        $hsl = false;
        $hsl2 = false;
        $hsl3 = false;
        if ($getcart != null) {

            $getprice = Product::where('id', $id_barang)->first();
            $total = $getprice->harga * $getcart->qty;
            $berat = $berat * $getcart->qty;

            $validate = Dumy::where('id_user', session('user-session')->id)
                ->where('id_barang', $id_barang)
                ->first();
            $getbarang = Product::where('id', $getcart->id_barang)->first();

            if ($validate != null) {
                $hsl = Dumy::where('id', $validate->id)->update([
                    'qty' => $getcart->qty,
                    'berat' => $berat,
                    'total' => $total
                ]);
            } else {
                $hsl = Dumy::create([
                    'id_transaction' => $transaction,
                    'id_user' => $getcart->id_user,
                    'id_barang' => $getcart->id_barang,
                    'qty' => $getcart->qty,
                    'berat' => $berat,
                    'total' => $total
                ]);

                /*$hsl3 = Payget::create([
                    'id_transaction' => $transaction,
                    'id_user' => $getcart->id_user,
                    'name' => $getbarang->nama,
                    'quantity' => $getcart->qty,
                    'price' =>  $getprice->harga
                ]);*/
            }

            $hsl2 = Cart::where('id', $getcart->id)->update([
                'status' => '1'
            ]);
        }


        if ($hsl && $hsl2) {
            if ($validate) {
                session(['id_transaction' => $validate->id_transaction]);
            } else {
                session(['id_transaction' => $transaction]);
            }
            session(['id_cart' => $getcart->id]);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
    public function update_dummy($id, $id_transaksi, $id_barang, $qty)
    {
        if (empty(session('user-session'))) {
            return redirect('/');
        }
        if (empty(session('user-session')->id)) {
            return redirect('/');
        }
        // dd($req->qty);
        $hsl = Cart::where('id', $id)->update([
            'qty' => $qty
        ]);
        if ($hsl) {
            $barang = Product::where('id', $id_barang)->first();

            Dumy::where('id_transaction', $id_transaksi)
                ->where('id_user', session('user-session')->id)
                ->where('id_barang', $id_barang)->update([
                    'qty' => $qty,
                    'berat' => $barang->berat * $qty,
                    'total' => $barang->harga * $qty
                ]);
                // Alert::success('Jumlah Barang berhasil diubah');
                if ($hsl) {
                           
                    Alert::toast('Jumlah Barang berhasil diubah', 'success');
                    return redirect()->back();
                } else {
                    Alert::toast('Jumlah Barang gagal diubah', 'error');
                    return redirect()->back();
                }
        }

        // $hsl = Cart::create([
        //     'id_user' => session('user-session')->id,
        //     'id_barang' => $req->id_barang,
        //     'qty' => $req->qty
        // ]);
        // if($hsl){
        //     return redirect('/cart')->with(['message' => 'Barang berhasil ditambah ke keranjang', 'alert' => 'success']);
        // }else{
        //     return redirect()->back()->with(['message' => 'Barang gagal ditambah ke keranjang', 'alert' => 'success']);
        // }
    }
    public function dummy(Request $req)
    {
        if (empty(session('user-session'))) {
            return redirect('/');
        }
        if (empty(session('user-session')->id)) {
            return redirect('/');
        }
        $getcart = Cart::with(['product', 'user'])
            ->where('id_user', '=', session('user-session')->id)
            ->where('id_barang', '=', $req->id_barang)
            ->first();
        $hsl2 = Cart::where('id', $getcart->id)->update([
            'status' => '1'
        ]);
        if ($hsl2) {

            session(['id_cart' => $getcart->id]);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
        /*     $total = $getcart->product->harga * $getcart->qty;
        $berat = $req->product->berat * $getcart->qty;
        $a = session('user-session')->id . rand(2, 50) . date('d-m-Y');
        $b = str_replace("-", "", $a);
        $transaction = 'TR-' . str_replace(".", "-", $b);
        $validate = Dumy::where('id_user', session('user-session')->id)->first();
        $getbarang = Product::where('id', $getcart->id_barang)->first();
        if ($validate) {
            $hsl = Dumy::create([
                'id_transaction' => $validate->id_transaction,
                'id_user' => $getcart->id_user,
                'id_barang' => $getcart->id_barang,
                'qty' => $getcart->qty,
                'berat' => $berat,
                'total' => $total
            ]);
            $hsl3 = Payget::create([
                'id_transaction' => $validate->id_transaction,
                'id_user' => $getcart->id_user,
                'name' => $getbarang->nama,
                'quantity' => $getcart->qty,
                'price' => $getprice->harga
            ]);
        } else {
            $hsl = Dumy::create([
                'id_transaction' => $transaction,
                'id_user' => $getcart->id_user,
                'id_barang' => $getcart->id_barang,
                'qty' => $getcart->qty,
                'berat' => $berat,
                'total' => $total
            ]);
            $hsl3 = Payget::create([
                'id_transaction' => $transaction,
                'id_user' => $getcart->id_user,
                'name' => $getbarang->nama,
                'quantity' => $getcart->qty,
                'price' =>  $getprice->harga
            ]);
        }

        $hsl2 = Cart::where('id', $getcart->id)->update([
            'status' => '1'
        ]);

            
        if ($hsl && $hsl2 && $hsl3) {
            if ($validate) {
                session(['id_transaction' => $validate->id_transaction]);
            } else {
                session(['id_transaction' => $transaction]);
            }
            session(['id_cart' => $getcart->id]);
            return redirect()->back();
        } else {
            return redirect()->back();
        }*/
    }
    public function find(Request $req)
    {
        if (empty(session('user-session'))) {
            return redirect('/');
        }
        if (empty(session('user-session')->id)) {
            return redirect('/');
        }
        $hsl = Cart::find($req->id);
        if ($hsl) {
            return response()->json($hsl);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan', 'error' => true]);
        }
    }
    public function updateqty(Request $req)
    {
        if (empty(session('user-session'))) {
            return redirect('/');
        }
        if (empty(session('user-session')->id)) {
            return redirect('/');
        }
        // dd($req->qty);
        $hsl = Cart::where('id', $req->id)->update([
            'qty' => $req->qty
        ]);
        if ($hsl) {
                           
            Alert::toast('Jumlah Barang berhasil diubah', 'success');
            return redirect()->back();
        } else {
            Alert::toast('Jumlah Barang gagal diubah', 'error');
            return redirect()->back();
        }

        // $hsl = Cart::create([
        //     'id_user' => session('user-session')->id,
        //     'id_barang' => $req->id_barang,
        //     'qty' => $req->qty
        // ]);
        // if($hsl){
        //     return redirect('/cart')->with(['message' => 'Barang berhasil ditambah ke keranjang', 'alert' => 'success']);
        // }else{
        //     return redirect()->back()->with(['message' => 'Barang gagal ditambah ke keranjang', 'alert' => 'success']);
        // }
    }
    public function deletedummy(Request $req)
    {
        if (empty(session('user-session'))) {
            return redirect('/');
        }
        if (empty(session('user-session')->id)) {
            return redirect('/');
        }
        //$getcart = Cart::where('id_barang', $req->id_barang)->first();
        //$getdummy = Dumy::where('id_barang', $req->id_barang)->first();
        $hsl = Cart::where('id', $req->id_cart)->update([
            'status' => '0'
        ]);
        return redirect()->back();
        /* $hsl2 = Dumy::where('id', $getdummy->id)->delete();
        if ($hsl && $hsl2) {
            return redirect()->back();
        } else {
            return redirect()->back();
        }*/
    }
}
