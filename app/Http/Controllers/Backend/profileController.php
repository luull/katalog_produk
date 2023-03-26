<?php

namespace App\Http\Controllers\backend;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Level_admin;
use Illuminate\Http\Request;

class profileController extends Controller
{
    public function index()
    {

        $backend_profil = session('backend-session');
        $level_admin = Level_admin::all();
        return view('backend.pages.profile_admin', compact('backend_profil', 'level_admin'));
    }


    public function update(Request $req)
    {

        $data = session('backend-session');
        $id = session('backend-session')->id;
        $hsl = Admin::find($id)->update([
            'nama' => $req->nama,
            'telp' => $req->telp,
            'email' => $req->email,
            'akses' => $req->akses

        ]);
        if ($hsl) {
            $data = Admin::find($id);
            session(['backend-session' => $data]);
            $des = "Update Admin, User ID " . $id;
            $a_data = array(
                session('backend-session')->id, request()->url(),
                request()->headers->get('referer'),
                $_SERVER['REMOTE_ADDR'],
                $des
            );
            save_event_log_admin($a_data);
            return redirect()->back()->with(['message' => 'Data Profile berhasil diupdate', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Data Profile gagal diupdate', 'alert' => 'error']);
        }
    }



    public function ubah_password()
    {

        return view('backend.pages.ubah_password');
    }
    public function proses_ubah_password(Request $req)
    {

        $data = session('backend-session');

        $req->validate([
            'password' => 'min:6|required_with:password1|same:password1',
            'password1' => 'required|min:6'
        ]);
        $hsl = Admin::find($data->id)->update([
            'pwd' => bcrypt($req->password)
        ]);
        if ($hsl) {
            $des = "Update Password, User ID " . session('backend_user_id');
            $a_data = array(
                session('backend-session')->id, request()->url(),
                request()->headers->get('referer'),
                $_SERVER['REMOTE_ADDR'],
                $des,
            );
            save_event_log_admin($a_data);
            return  redirect()->back()->with(['message' => 'Password Berhasil diubah', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Password Gagal diubah', 'alert' => 'error']);
        }
    }

    public function upload_foto()
    {

        return view('backend.pages.photo_profil');
    }
    public function proses_upload_foto(Request $req)
    {

        $req->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);



        if ($req->hasFile('foto')) {
            $data = session('backend-session');
            $file_foto = str_replace($data->nama, " ", "") . $data->id . "." . $req->foto->getClientOriginalExtension();
            $namafile = "/photos/" . $file_foto;
            if (file_exists(public_path() . '/' . $namafile)) {
                unlink(public_path() . '/' . $namafile);
            }
            $file = $req->file('foto');
            $extension = $file->getClientOriginalExtension();
            $name = $file_foto;
            $hasil = $file->move(public_path() . '/photos/', $name);
            if ($hasil) {
                $data_admin = Admin::find($data->id);
                $data_admin->update([
                    'foto' => $namafile
                ]);
                session(['backend-session' => $data_admin]);
                $des = "Upload Foto Profil Admin Sukses, User ID " . session('backend_user_id') . " File Foto " . $namafile;

                $a_data = array(
                    session('backend-session')->id, request()->url(),
                    request()->headers->get('referer'),
                    $_SERVER['REMOTE_ADDR'],
                    $des,
                );
                save_event_log_admin($a_data);
                return  redirect()->back()->with(['message' => 'Upload Foto Berhasil', 'alert' => 'success']);
            } else {
                return redirect()->back()->with(['message' => 'Upload Foto Gagal', 'alert' => 'error']);
            }
        }
    }
}
