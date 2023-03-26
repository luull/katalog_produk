<?php

namespace App\Http\Controllers\backend;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Level_admin;
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function index()
    {

        if (session('backend-session')->akses == 1) {
            $admin = Admin::with('level_admin')->get();
            $level_admin = Level_admin::all();
        } else {
            $admin = Admin::where('id', '=', session('backend-session')->id)
                ->orWhere('akses', '>', session('backend-session')->akses)
                ->get();
            $level_admin = Level_admin::where('kode', '>=', session('backend-session')->akses)->get();
        }
        return view('backend.pages.admin', compact('admin', 'level_admin'));
    }
    public function delete(Request $req)
    {

        $dt = Admin::find($req->id);
        if ($dt) {

            $gbr = $dt->gambar;
            $hsl = $dt->delete();

            if ($hsl) {
                if (!empty($gbr)) {
                    if (file_exists(public_path() . '/' . $gbr)) {
                        unlink(public_path() . '/' . $gbr);
                    }
                }

                return redirect()->back()->with(['message' => 'Data berhasil dihapus', 'alert' => 'success']);
            } else {
                return redirect()->back()->with(['message' => 'Data gagal dihapus', 'alert' => 'danger']);
            }
        } else {
            return redirect()->back()->with(['message' => 'Data tidak ditemukan ', 'alert' => 'danger']);
        }
    }
    public function find(Request $req)
    {

        $hsl = Admin::with('level_admin')->find($req->id);
        $data_level = Level_admin::all();
        if ($hsl) {
            return response()->json(['hasil' => $hsl, 'level_admin' => $hsl->level_akses, 'data_level' => $data_level]);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan', 'error' => true]);
        }
    }
    public function update(Request $request)
    {

        if (!empty($request->id)) {
            $validasi = $request->validate([
                'edit_uid' => 'required',
                'edit_nama' => 'required',
                'edit_telp' => 'required',
                'edit_email' => 'required',
                'edit_akses' => 'required',


            ]);

            if ($validasi) {

                $hsl = Admin::where('id', $request->id)
                    ->update([
                        'username' => $request->edit_uid,
                        'nama' => $request->edit_nama,
                        'telp' => $request->edit_telp,
                        'email' => $request->edit_email,
                        'akses' => $request->edit_akses,

                    ]);
                if ($hsl) {
                    return redirect()->back()->with(['message' => 'Data Berhasil diubah', 'alert' => 'success']);
                } else {
                    return redirect()->back()->with(['message' => 'Data gagal diubah', 'alert' => 'danger']);
                }
            } else {
                return redirect()->back()->with(['message' => 'Data yang diubah belum lengkap ', 'alert' => 'danger']);
            }
        } else {
            return redirect()->back()->with(['message' => 'Data yang diubah belum lengkap,idnya kosong ', 'alert' => 'danger']);
        }
    }
    public function create(Request $request)
    {

        $validasi = $request->validate([
            'uid' => 'required',
            'pwd' => 'required',
            'nama' => 'required',
            'telp' => 'required',
            'email' => 'required'
        ]);
        $cek = Admin::where('uid', $request->uid)->get();
        if (count($cek) > 0) {
            return redirect()->back()->with(['message' => 'Username ' . $request->uid . ' sudah digunakan', 'alert' => 'danger']);
        }

        if ($validasi) {
            $foto = 'images/no-pic.jpg';

            $hsl = Admin::create([
                'username' => $request->uid,
                'password' => bcrypt($request->pwd),
                'nama' => $request->nama,
                'email' => $request->email,
                'telp' => $request->telp,
                'foto' => $foto
            ]);
            if ($hsl) {
                return redirect()->back()->with(['message' => 'Data Berhasil Ditambahkan ', 'alert' => 'success']);
            } else {
                return redirect()->back()->with(['message' => 'Data gagal ditambahkan', 'alert' => 'danger']);
            }
        } else {
            return redirect()->back()->with(['message' => 'Data belum lengkap', 'alert' => 'danger']);
        }
    }
    public function proses_ubah_password(Request $req)
    {

        $req->validate([
            'new_password' => 'min:6|required_with:new_password|same:confirm_password',
            'confirm_password' => 'required|min:6'
        ]);
        $hsl = Admin::find($req->user_id)->update([
            'password' => bcrypt($req->new_password)
        ]);
        if ($hsl) {
            $des = "Update Password, User ID " . $req->user_id;
            $a_data = array(
                $req->user_id, request()->url(),
                request()->headers->get('referer'),
                $_SERVER['REMOTE_ADDR'],
                $des,
            );
            save_event_log_admin($a_data);
            return redirect()->back()->with(['message' => 'Password berhasil diubah ', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Password Gagal diubah', 'alert' => 'error']);
        }
    }
}
