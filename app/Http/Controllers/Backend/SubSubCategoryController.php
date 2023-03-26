<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\SubCategory;
use App\Http\Controllers\Controller;
use App\SubSubCategory;
use Illuminate\Http\Request;

class SubSubCategoryController extends Controller
{
    public function index()
    {

        $data = SubSubCategory::with(['category', 'sub_category'])->get();
        $category = Category::all();
        $subcategory = SubCategory::all();
        //dd($data[0]->sub_sub_category[0]->name);
        return view('backend.pages.sub_sub_category', compact('data', 'category', 'subcategory'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'id_category' => 'required',
            'id_sub_category' => 'required',
            'name' => 'required',
        ]);
        $hsl = SubSubCategory::create([
            'id_category' => $request->id_category,
            'id_sub_category' => $request->id_sub_category,
            'name' => $request->name,
            'created_by' => session('backend-session')->username
        ]);
        if ($hsl) {
            return redirect()->back()->with(['message' => 'Sub Sub category has been created', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'Sub Sub category failed created', 'color' => 'alert-danger']);
        }
    }
    public function find(Request $req)
    {
        $hsl = SubSubCategory::find($req->id);
        if ($hsl) {
            return response()->json($hsl);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan', 'error' => true]);
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'edit_id_category' => 'required',
            'edit_id_sub_category' => 'required',
            'edit_name' => 'required',
        ]);
        $hsl = SubSubCategory::find($request->id)->update([
            'id_category' => $request->edit_id_category,
            'id_sub_category' => $request->edit_id_sub_category,
            'name' => $request->edit_name,
        ]);
        if ($hsl) {
            return redirect()->back()->with(['message' => 'sub category has been updated', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'sub category failed updated', 'color' => 'alert-danger']);
        }
    }
    public function delete(Request $request)
    {
        $hsl = SubSubCategory::find($request->id)->delete();
        if ($hsl) {
            return redirect()->back()->with(['message' => 'sub category has been deleted', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'sub category failed deleted', 'color' => 'alert-danger']);
        }
    }
    public function getsubcategory(Request $req)
    {
        $id = $req->id;
        $subcategory = SubSubCategory::where('id_sub_category', $id)->get();
        if (count($subcategory) > 0) {
            $data = array(
                'code' => 200,
                'result' => $subcategory
            );
            $code = 200;
        } else {
            $code = 404;
            $data = array(
                'code' => 404,
                'error' => 'Sub Category ID not Found'
            );
        }
        return  response()->json($data, $code);
    }
}
