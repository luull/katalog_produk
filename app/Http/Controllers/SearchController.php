<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Category;
use App\DefaultProduct;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $req)
    {

        if (session('user-session') != null) {
            $countcart = Cart::where('id_user', session('user-session')->id)->count();
            session(['countcart' => $countcart]);
        } else {
            $countcart = 'kosong';
            session(['countcart' => $countcart]);
        }
        $search = $req->search;
        if ($search === '') {
            redirect('/');
        }
        $category = Category::get();
        $product = Product::with(['category', 'sub_category', 'sub_sub_category'])
            ->where('nama', 'LIKE', '%' . $search . '%')
            ->get();
            // dd($product[1]->sub_category->name);
        return view("pages.product", compact('product', 'search', 'category'));
    }
    public function defaultproduk(Request $req)
    {
        $product = Product::where('id', $req->id)->first();
        return view("pages.detilProduk", compact('product'));
    }

    public function filter(Request $req)
    {
        $id = $req->id;
        $search = $req->search;
        $product = Product::where('nama', 'LIKE', '%' . $search . '%')->get();
        $getid = Product::where('nama', 'LIKE', '%' . $search . '%')->first();
        $category = DB::table('category')
            ->join('sub_category', 'sub_category.id_category', '=', 'category.id')
            ->select('category.*', 'category.id as cid', 'sub_category.*')
            ->get();
        $getcategory = Category::where('id', $id)->first();
        return view("pages.filter", compact('product', 'getcategory', 'category', 'id', 'getid'));
    }
}
