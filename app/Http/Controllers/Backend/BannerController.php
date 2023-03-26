<?php

namespace App\Http\Controllers\Backend;

use App\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class bannerController extends Controller
{
    public function index()
    {

        $data = Banner::all();
        return view('backend.pages.banner', compact('data'));
    }
    public function create(Request $request)
    {
        $request->validate([

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $image = '';
        if ($request->hasfile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('backend/banner'), $imageName);
            $image = "backend/banner/$imageName";
        }
        $hsl = Banner::create([
            'image' => $image,
            'created_by' => session('backend-session')->username
        ]);
        if ($hsl) {
            return redirect()->back()->with(['message' => 'banner has been created', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'banner failed created', 'color' => 'alert-danger']);
        }
    }
    public function find(Request $req)
    {
        $hsl = Banner::find($req->id);
        if ($hsl) {
            return response()->json($hsl);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan', 'error' => true]);
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $image = '';
        if ($request->hasfile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('backend/banner'), $imageName);
            $image = "backend/banner/$imageName";
        } else {
            $image = $request->default;
        }
        $hsl = Banner::find($request->id)->update([
            'image' => $image,
        ]);
        if ($hsl) {
            return redirect()->back()->with(['message' => 'banner has been updated', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'banner failed updated', 'color' => 'alert-danger']);
        }
    }
    public function delete(Request $request)
    {
        $get = Banner::where('id', $request->id)->first();
        $hsl = unlink(public_path($get->image));
        if ($hsl) {
            Banner::find($request->id)->delete();
            return redirect()->back()->with(['message' => 'banner has been deleted', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'banner failed deleted', 'color' => 'alert-danger']);
        }
    }
}
