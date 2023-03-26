<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pages;
use Exception;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    public function index(Request $req)
    {
        $data = Pages::get();
        return view('backend.pages.pages', compact('data'));
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'content' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $image = '';
            if ($request->hasfile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $image = "images/$imageName";
            }
            $slug = Str::slug($request->title);
            $cek = Pages::where('title', $request->title)->first();
            if ($cek) {
                return redirect()->back()->with(['message' => 'Pages sudah terdaftar', 'color' => 'alert-danger'])->withInput($request->all());
            } else {

                $hsl = Pages::create([
                    'title' => $request->title,
                    'slug' => $slug,
                    'content' => $request->content,
                    'image' => $image,
                ]);

                if ($hsl) {
                    return redirect()->back()->with(['message' => 'Pages berhasil dibuat', 'color' => 'alert-success']);
                } else {
                    return redirect()->back()->with(['message' => 'Pages gagal dibuat', 'color' => 'alert-danger'])->withInput($request->all());
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => 'Pages gagal dibuat ' . $e->getMessage(), 'color' => 'alert-danger'])->withInput($request->all());
        }
    }
    public function find(Request $req)
    {
        $hsl = Pages::find($req->id);
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
                'edit_title' => 'required',
                'edit_content' => 'required',

            ]);

            $image = '';
            if ($request->hasfile('edit_image')) {
                $imageName = time() . '.' . $request->edit_image->extension();
                $request->edit_image->move(public_path('images'), $imageName);
                $image = "images/$imageName";
            } else {
                $image = $request->default;
            }
            $slug = Str::slug($request->edit_title);

            $hsl = Pages::find($request->id)->update([
                'title' => $request->edit_title,
                'slug' => $slug,
                'content' => $request->edit_content,
                'image' => $image,
            ]);
            if ($hsl) {
                return redirect()->back()->with(['message' => 'Pages telah berhasil diupdate', 'color' => 'alert-success']);
            } else {
                return redirect()->back()->with(['message' => 'Pages gagal  diupdate', 'color' => 'alert-danger']);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => 'Pages gagal  diupdate ' . $e->getMessage(), 'color' => 'alert-danger']);
        }
    }
    public function delete(Request $request)
    {
        try {
            $get = Pages::where('id', $request->id)->first();
            Pages::find($request->id)->delete();
            $hsl = unlink(public_path($get->image));

            return redirect()->back()->with(['message' => 'Pages telah berhasil dihapus', 'color' => 'alert-success']);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => 'Pages gagal  dihapus ' . $e->getMessage(), 'color' => 'alert-danger']);
        }
    }
}
