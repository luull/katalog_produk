<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\SubCategory;
use App\SubSubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $category = Category::get();
        $product = Product::with('category', 'sub_category', 'sub_sub_category')->get();

        return view('pages.product', compact('product', 'category'));
    }

    public function price_range(Request $req)
    {
        $product = Product::with('category', 'sub_category', 'sub_sub_category')
            ->where('harga', '>=', $req->h1)
            ->where('harga', '<=', $req->h2)
            ->get();

        $count = $product->count();
        $judul = "Daftar Produk Dengan Range Harga " . number_format($req->h1) . ' s/d ' . number_format($req->h2);
        return response()->json(['record' => $count, 'title' => $judul, 'data' => $product]);
    }
    public function category(Request $req)
    {
        $product = Product::with('category', 'sub_category', 'sub_sub_category')
            ->where('kategori', $req->id)
            ->get();
        $count = $product->count();
        if ($count > 0) {
            $judul = "Daftar Produk Kategori " . $product[0]->category->name;
        } else {
            $sub_cat = Category::where('id', $req->id)->first('name');
            if ($sub_cat) {
                $judul = "Daftar Produk Kategori " . $sub_cat->name;
            } else {
                $judul = "Kategori Produk tidak ditemukan";
            }
        }
        return response()->json(['record' => $count, 'title' => $judul, 'data' => $product, 'name' => $product[0]->category->name]);
    }
    public function sub_category(Request $req)
    {
        $product = Product::with('category', 'sub_category', 'sub_sub_category')
            ->where('sub_kategori', $req->id)
            ->get();

        $count = $product->count();
        if ($count > 0) {
            $judul = "Daftar Produk Sub Kategori " . $product[0]->sub_category->name;
        } else {
            $sub_cat = SubCategory::where('id', $req->id)->first('name');
            if ($sub_cat) {
                $judul = "Daftar Produk Sub Kategori " . $sub_cat->name;
            } else {
                $judul = "Sub Kategori Produk tidak ditemukan";
            }
        }

        return response()->json(['record' => $count, 'title' => $judul, 'data' => $product, 'name' => $product[0]->category->name, 'name2' => $product[0]->sub_category->name]);
    }
    public function sub_sub_category(Request $req)
    {
        $product = Product::with('category', 'sub_category', 'sub_sub_category')
            ->where('sub_sub_kategory', $req->id)
            ->get();
        $count = $product->count();
        if ($count > 0) {
            $judul = "Daftar Produk Sub Kategori " . $product[0]->sub_sub_category->name;
        } else {
            $sub_cat = SubSubCategory::where('id', $req->id)->first('name');
            if ($sub_cat) {
                $judul = "Daftar Produk Sub Kategori " . $sub_cat->name;
            } else {
                $judul = "Sub Kategori Produk tidak ditemukan";
            }
        }
        return response()->json(['record' => $count, 'title' => $judul, 'data' => $product, 'name' => $product[0]->category->name,'name2' => $product[0]->sub_category->name,'name3' => $product[0]->sub_sub_category->name]);
    }
    public function detilproduk(Request $req)
    {
        $product = Product::where('slug', $req->slug)->first();
        $reff = $req->reff;
        if ($reff) {
            $cookie_name = env('STORE_NAME');
            get_refferal($reff);
            $data = json_decode($_COOKIE[$cookie_name]);
            session(['data_refferal' => $data]);
        }
        return view("pages.detilProduk", compact('product', 'reff'));
    }

    public function produk(Request $req)
    {
        $produk = Product::where('id', $req->id)->first();
        return view("pages.detilProduk", compact('produk'));
    }
}
