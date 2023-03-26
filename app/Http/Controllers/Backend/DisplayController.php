<?php

namespace App\Http\Controllers\Backend;

use App\Display;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\DB;

class displayController extends Controller
{
    public function index()
    {

        $product = Product::all();
        $data = Display::with('product')
            ->orderBy('id', 'DESC')
            ->get();
        return view('backend.pages.display', compact('data', 'product'));
    }
    public function find(Request $req)
    {
        $hsl = Display::find($req->id);
        if ($hsl) {
            return response()->json($hsl);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan', 'error' => true]);
        }
    }
    public function create(Request $request)
    {

        $validasi = $request->validate([
            'produk_id' => 'required',
        ]);
        if ($validasi) {
            $hsl = Display::create([
                'produk_id' => $request->produk_id,
            ]);
            if ($hsl) {
                return redirect()->back()->with(['message' => 'Data Berhasil Ditambahkan ', 'color' => 'alert-success']);
            } else {
                return redirect()->back()->with(['message' => 'Data gagal ditambahkan', 'color' => 'alert-danger']);
            }
        } else {
            return redirect()->back()->with(['message' => 'Data yang diinputan belum lengkap ', 'color' => 'alert-danger']);
        }
    }

    public function update(Request $request)
    {

        $validasi = $request->validate([
            'produk_id' => 'required',
        ]);

        if ($validasi) {
            $hsl = Display::find($request->id)->update([
                'produk_id' => $request->produk_id,
            ]);
            if ($hsl) {
                return redirect()->back()->with(['message' => 'Data Berhasil diubah', 'color' => 'alert-success']);
            } else {
                return redirect()->back()->with(['message' => 'Data gagal diubah', 'color' => 'alert-danger']);
            }
        } else {
            return redirect()->back()->with(['message' => 'Data yang diubah belum lengkap ', 'color' => 'alert-danger']);
        }
    }

    public function delete(Request $request)
    {
        $hsl = Display::find($request->id)->delete();
        if ($hsl) {
            return redirect()->back()->with(['message' => 'Data has been deleted', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'Data failed deleted', 'color' => 'alert-danger']);
        }
    }
}
