<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Cart;
use App\City;
use App\Company;
use App\Category;
use App\Product;
use App\Province;
use App\Subdistrict;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
Use Alert;
class HomeController extends Controller
{

    public function replika(Request $req)
    {
        get_refferal($req->id);

        return redirect('/');
    }
    public function dashboard()
    {
        try {
            if (session('company') == null) {
                $company = Company::first();
                session(['company' => $company]);
                $cookie_name = $company->nama;
            } else {
                $cookie_name = env('STORE_NAME');
            }
            if (isset($_COOKIE[$cookie_name])) {
                //$data = json_decode($_COOKIE[$cookie_name]);
                $data = json_decode($_COOKIE[$cookie_name]);
                if (session('user-session') != null) {
                    if ($data->username != session('user-session')->refferal) {
                        get_refferal(session('user-session')->refferal);
                    }
                }
            } else {
                if (session('user-session') != null) {
                    $id = session('user-session')->refferal;
                } else {

                    $id = env('DEFAULT_MEMBER_ID');
                }
                return redirect('/' . $id);
            }

            if (isset($_COOKIE[$cookie_name])) {
                $data = json_decode($_COOKIE[$cookie_name]);
                session(['data_refferal' => $data]);
            }
            if (session('user-session') != null) {
                $countcart = Cart::where('id_user', session('user-session')->id)->count();
                session(['countcart' => $countcart]);
            } else {
                $countcart = 'kosong';
                session(['countcart' => $countcart]);
            }
            $produk_display = DB::table('product')
                ->join('display', 'display.produk_id', '=', 'product.id')
                ->select('product.*', 'product.id as idprod', 'display.id')
                ->orderBy('display.id', 'DESC')
                ->where('product.show', true)
                ->get();
            $banner = Banner::where('show', 1)->get();
            $gets = Category::all();
            $category = $gets->toArray();

            // dd($category);
            $product = Product::where('show', true)->get();
            session(['data-product' => $product]);
            // dd(session('product'));
            return view("pages.home", compact('product', 'produk_display', 'banner','category'));
        } catch (Exception $e) {
            Alert::error('Mohon maaf server ada sedikit masalah.. silahkan hubungi admin');
            return redirect()->back();
        }
    }
    public function city_list(Request $req)
    {
        $get = Province::where('province', $req->id)->first()->id;
        $city = City::where('province_id', $get)->get();
        if (count($city) > 0) {
            $data = array(
                'code' => 200,
                'result' => $city
            );
            $code = 200;
        } else {
            $code = 404;
            $data = array(
                'code' => 404,
                'error' => 'Province ID not Found'
            );
        }
        return  response()->json($data, $code);
    }
    public function subdistrict_list(Request $req)
    {
        $kec = Subdistrict::where('city_id', $req->id)->get();
        if (count($kec) > 0) {
            $data = array(
                'code' => 200,
                'result' => $kec
            );
            $code = 200;
        } else {
            $code = 404;
            $data = array(
                'code' => 404,
                'error' => 'City ID not Found'
            );
        }

        return  response()->json($data, $code);
    }
}
