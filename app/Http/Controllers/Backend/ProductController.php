<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\Product;
use App\Http\Controllers\Controller;
use App\Satuan;
use App\SubCategory;
use App\SubSubCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class productController extends Controller
{
    public function index()
    {

        $data = Product::with(['category', 'sub_category', 'sub_sub_category'])
            ->orderBy('id', 'desc')->get();

        $category = Category::all();
        $subcategory = SubCategory::all();
        $subsubcategory = SubSubCategory::all();
        $satuan = Satuan::all();
        return view('backend.pages.product', compact('data', 'category', 'subcategory', 'subsubcategory', 'satuan'));
    }
    public function detil_produk(Request $req)
    {
        $product = Product::where('slug', $req->slug)->first();

        return view("backend.pages.detilProduk", compact('product'));
    }
    public function create(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'berat' => 'required',
                'harga' => 'required',
                'stok' => 'required',
                'satuan' => 'required',
                'keterangan_singkat' => 'required',
                'keterangan' => 'required',
                'kategori' => 'required',
                'sub_kategori' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $image = '';
            if ($request->hasfile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('product'), $imageName);
                $image = "product/$imageName";
            }
            $slug = Str::slug($request->nama);
            $cek = Product::where('kode_brg', $request->kode_brg)
                ->OrWhere('nama', $request->nama)->first();
            if ($cek) {
                return redirect()->back()->with(['message' => 'Kode Barang atau Nama Barang sudah terdaftar', 'color' => 'alert-danger'])->withInput($request->all());
            } else {

                $hsl = Product::create([
                    'kode_brg' => $request->kode_brg,
                    'slug' => $slug,
                    'nama' => $request->nama,
                    'berat' => $request->berat,
                    'stok' => $request->stok,
                    'harga' => $request->harga,
                    'satuan' => $request->satuan,
                    'keterangan_singkat' => $request->keterangan_singkat,
                    'keterangan' => $request->keterangan,
                    'kategori' => $request->kategori,
                    'sub_kategori' => $request->sub_kategori,
                    'sub_sub_kategory' => $request->sub_sub_kategory,
                    'image' => $image,
                    'date_created' => date('Y-m-d h:i:s'),
                    'created_by' => session('backend-session')->username
                ]);

                if ($hsl) {
                    return redirect()->back()->with(['message' => 'Product berhasil dibuat', 'color' => 'alert-success']);
                } else {
                    return redirect()->back()->with(['message' => 'Product gagal dibuat', 'color' => 'alert-danger'])->withInput($request->all());
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => 'Product gagal dibuat ' . $e->getMessage(), 'color' => 'alert-danger'])->withInput($request->all());
        }
    }
    public function find(Request $req)
    {
        $hsl = Product::find($req->id);
        if ($hsl) {
            return response()->json($hsl);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan', 'error' => true]);
        }
    }
    public function update(Request $request)
    {
        try {

            $request->validate([
                'edit_nama' => 'required',
                'edit_berat' => 'required',
                'edit_stok' => 'required',
                'edit_harga' => 'required',
                'edit_satuan' => 'required',
                'edit_keterangan_singkat' => 'required',
                'edit_keterangan' => 'required',
                'edit_kategori' => 'required',

            ]);

            $image = '';
            if ($request->hasfile('edit_image')) {
                $imageName = time() . '.' . $request->edit_image->extension();
                $request->edit_image->move(public_path('product'), $imageName);
                $image = "product/$imageName";
            } else {
                $image = $request->default;
            }
            $slug = Str::slug($request->edit_nama);

            $hsl = Product::find($request->id)->update([
                'kode_brg' => $request->edit_kode_brg,
                'slug' => $slug,
                'nama' => $request->edit_nama,
                'berat' => $request->edit_berat,
                'stok' => $request->edit_stok,
                'harga' => $request->edit_harga,
                'satuan' => $request->edit_satuan,
                'keterangan_singkat' => $request->edit_keterangan_singkat,
                'keterangan' => $request->edit_keterangan,
                'kategori' => $request->edit_kategori,
                'sub_kategori' => $request->edit_sub_kategori,
                'sub_sub_kategory' => $request->edit_sub_sub_kategori,
                'image' => $image,
            ]);
            if ($hsl) {
                return redirect()->back()->with(['message' => 'Produk telah berhasil diupdate', 'color' => 'alert-success']);
            } else {
                return redirect()->back()->with(['message' => 'Produk gagal  diupdate', 'color' => 'alert-danger']);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => 'Produk gagal  diupdate ' . $e->getMessage(), 'color' => 'alert-danger']);
        }
    }
    public function delete(Request $request)
    {
        $get = Product::where('id', $request->id)->first();
        $hsl = unlink(public_path($get->image));
        if ($hsl) {
            Product::find($request->id)->delete();
            return redirect()->back()->with(['message' => 'Produk telah berhasil dihapus', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'Produk gagal  dihapus', 'color' => 'alert-danger']);
        }
    }
    public function sub_category(Request $req)
    {
        $data = SubCategory::where('id_category', $req->id)->get();
        $jml = $data->count();
        return response()->json(['record' => $jml, 'data' => $data]);
    }
    public function sub_sub_category(Request $req)
    {
        $data = SubSubCategory::where('id_sub_category', $req->id)->get();
        $jml = $data->count();
        return response()->json(['record' => $jml, 'data' => $data]);
    }
}
