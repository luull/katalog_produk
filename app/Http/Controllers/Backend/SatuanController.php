<?php

namespace App\Http\Controllers\Backend;

use App\Satuan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index()
    {

        $data = Satuan::all();
        return view('backend.pages.satuan', compact('data'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);
        $hsl = Satuan::create([
            'nama' => $request->nama,
        ]);
        if ($hsl) {
            return redirect()->back()->with(['message' => 'Satuan has been created', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'Satuan failed created', 'color' => 'alert-danger']);
        }
    }
    public function find(Request $req)
    {
        $hsl = Satuan::find($req->id);
        if ($hsl) {
            return response()->json($hsl);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan', 'error' => true]);
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required',

        ]);

        $hsl = Satuan::find($request->id)->update([
            'nama' => $request->nama,
        ]);
        if ($hsl) {
            return redirect()->back()->with(['message' => 'Satuan has been updated', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'Satuan failed updated', 'color' => 'alert-danger']);
        }
    }
    public function delete(Request $request)
    {
        $hsl = Satuan::find($request->id)->delete();
        if ($hsl) {
            return redirect()->back()->with(['message' => 'Satuan has been deleted', 'color' => 'alert-success']);
        } else {
            return redirect()->back()->with(['message' => 'Satuan failed deleted', 'color' => 'alert-danger']);
        }
    }
}
