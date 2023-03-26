<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class categoryController extends Controller
{
    public function index()
    {

        $data = Category::all();
        return view('backend.pages.category', compact('data'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $hsl = Category::create([
            'name' => $request->name,
            'created_by' => session('backend-session')->username
        ]);
        if ($hsl) {
            return redirect()->back()->with(['message' => 'category has been created', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'category failed created', 'color' => 'alert-danger']);
        }
    }
    public function find(Request $req)
    {
        $hsl = Category::find($req->id);
        if ($hsl) {
            return response()->json($hsl);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan', 'error' => true]);
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',

        ]);

        $hsl = Category::find($request->id)->update([
            'name' => $request->name,
        ]);
        if ($hsl) {
            return redirect()->back()->with(['message' => 'category has been updated', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'category failed updated', 'color' => 'alert-danger']);
        }
    }
    public function delete(Request $request)
    {
        $hsl = Category::find($request->id)->delete();
        if ($hsl) {
            return redirect()->back()->with(['message' => 'category has been deleted', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'category failed deleted', 'color' => 'alert-danger']);
        }
    }
}
