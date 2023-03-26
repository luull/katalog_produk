<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\SubCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class subCategoryController extends Controller
{
    public function index()
    {

        $data = SubCategory::with(['category', 'sub_sub_category'])->get();
        $category = Category::all();
        //dd($data[0]->sub_sub_category[0]->name);
        return view('backend.pages.sub_category', compact('data', 'category'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'id_category' => 'required',
            'sub_category' => 'required',
        ]);
        $hsl = SubCategory::create([
            'id_category' => $request->id_category,
            'sub_category' => $request->sub_category,
            'name' => $request->sub_category,
            'created_by' => session('backend-session')->username
        ]);
        if ($hsl) {
            return redirect()->back()->with(['message' => 'sub category has been created', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'sub category failed created', 'color' => 'alert-danger']);
        }
    }
    public function find(Request $req)
    {
        $hsl = SubCategory::find($req->id);
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
            'edit_sub_category' => 'required',
        ]);

        $hsl = SubCategory::find($request->id)->update([
            'id_category' => $request->edit_id_category,
            'name' => $request->edit_sub_category,
        ]);
        if ($hsl) {
            return redirect()->back()->with(['message' => 'sub category has been updated', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'sub category failed updated', 'color' => 'alert-danger']);
        }
    }
    public function delete(Request $request)
    {
        $hsl = SubCategory::find($request->id)->delete();
        if ($hsl) {
            return redirect()->back()->with(['message' => 'sub category has been deleted', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'sub category failed deleted', 'color' => 'alert-danger']);
        }
    }
    public function getsubcategory(Request $req)
    {
        $id = $req->id;
        $subcategory = SubCategory::where('id_category', $id)->get();
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
