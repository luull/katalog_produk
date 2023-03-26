<?php

namespace App\Http\Controllers\backend;

use App\Branch;
use App\City;
use App\Http\Controllers\Controller;
use App\Province;
use App\Subdistrict;
use Exception;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $data = Branch::get();
        $province = Province::get();
        return view('backend.pages.branch', compact('data', 'province'));
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'branch_id' => 'required',
                'province' => 'required',
                'name' => 'required',
                'password' => 'required',
                'city' => 'required',
                'subdistrict' => 'required',
            ]);
            $cek = Branch::where('branch_id', $request->branch_id)
                ->first();
            if ($cek) {
                return redirect()->back()->with(['message' => 'Kode Mitrasaur sudah terdaftar', 'color' => 'alert-danger'])->withInput($request->all());
            } else {
                $prov = Province::where('province_id', $request->province)->first();

                $hsl = Branch::create([
                    'branch_id' => $request->branch_id,
                    'password' => bcrypt($request->password),
                    'name' => $request->name,
                    'propinsi' => $prov->province,
                    'province' => $request->province,
                    'city' => $request->city,
                    'subdistrict' => $request->subdistrict,
                    'zip' => $request->zip,
                    'main_office' => 0,
                    'count' => 0,

                    'created_by' => session('backend-session')->username
                ]);

                if ($hsl) {
                    return redirect()->back()->with(['message' => 'Mitrasalur berhasil dibuat', 'color' => 'alert-success']);
                } else {
                    return redirect()->back()->with(['message' => 'Mitrasalur gagal dibuat', 'color' => 'alert-danger'])->withInput($request->all());
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => 'Mitrasalur gagal dibuat ' . $e->getMessage(), 'color' => 'alert-danger'])->withInput($request->all());
        }
    }
    public function find(Request $req)
    {
        $hsl = Branch::find($req->id);
        if ($hsl) {
            return response()->json($hsl);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan', 'error' => true]);
        }
    }
    public function set_password(Request $request)
    {
        try {
            $branch = Branch::find($request->pass_id);
            if ($branch) {
                $branch->update([
                    'password' => bcrypt($request->new_password),
                    'updated_at' => date('Y-m-d h:i:s'),
                    'updated_by' => session('backend-session')->username,
                ]);
                return redirect()->back()->with(['message' => 'Password Mitrasalur telah berhasil diupdate', 'color' => 'alert-success']);
            } else {

                return redirect()->back()->with(['message' => 'Password Mitrasalur gagal  diupdate', 'color' => 'alert-danger'])->withInput($request->all());
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => 'Password Mitrasalur gagal  diupdate ' . $e->getMessage(), 'color' => 'alert-danger'])->withInput($request->all());
        }
    }
    public function update(Request $request)
    {
        try {

            $request->validate([
                'edit_province' => 'required',
                'edit_city' => 'required',
                'edit_subdistrict' => 'required',

            ]);
            $prov = Province::where('province_id', $request->edit_province)->first();
            $hsl = Branch::find($request->id)->update([
                'name' => $request->edit_name,
                'propinsi' => $prov->province,
                'province' => $request->edit_province,
                'city' => $request->edit_city,
                'subdistrict' => $request->edit_subdistrict,
                'zip' => $request->edit_zip,
                'updated_at' => date('Y-m-d h:i:s'),
                'updated_by' => session('backend-session')->username
            ]);
            if ($hsl) {
                return redirect()->back()->with(['message' => 'Mitrasalur telah berhasil diupdate', 'color' => 'alert-success']);
            } else {
                return redirect()->back()->with(['message' => 'Mitrasalur gagal  diupdate', 'color' => 'alert-danger'])->withInput($request->all());
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => 'Mitrasalur gagal  diupdate ' . $e->getMessage(), 'color' => 'alert-danger'])->withInput($request->all());
        }
    }
    public function delete(Request $request)
    {
        try {
            $get = Branch::where('id', $request->id)->first();
            Branch::find($request->id)->delete();
            return redirect()->back()->with(['message' => 'Mitrasalur telah berhasil dihapus', 'color' => 'alert-success']);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => 'Proses Delete Error ' . $e->getMessage(), 'color' => 'alert-success']);
        }
    }
    public function get_city(Request $req)
    {
        $hsl = City::where('province_id', $req->id)->get();
        if ($hsl) {
            return response()->json(['record' => count($hsl), 'data' => $hsl]);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan', 'error' => true]);
        }
    }
    public function get_subdistrict(Request $req)
    {
        $hsl = Subdistrict::where('city_id', $req->id)->get();
        if ($hsl) {

            return response()->json(['record' => count($hsl), 'data' => $hsl]);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan', 'error' => true]);
        }
    }
}
