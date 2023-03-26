<?php

namespace App\Http\Controllers\Auth;

use App\Cart;
use App\Http\Controllers\Controller;
use App\DefaultProduct;
use App\Dumy;
use App\User;
use App\Users;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view("pages.login");
    }
    public function login(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'password' => 'required|string',
            ]);
            session(['isCustomerLogin' => false]);


            $uid = $request->name;
            $pwd = $request->password;
            $data = User::where('username', $uid)->first();

            if ($data) {
                if ($data['google_id'] != NULL) {
                    return redirect()->back()->with('message', 'Akun anda terkait dengan Google');
                }
                if (Hash::check($pwd, $data->password)) {
                    if ($data->email_verified_at != NULL) {
                        session(['user-session' => $data]);
                        get_refferal($data->refferal);
                        session(['isCustomerLogin' => true]);
                        return redirect('/');
                    } else {
                        return redirect()->back()->with('message', 'Username  ' . $uid . ' belum aktif silahkan lakukan konfirmasi dari email Anda');
                    }
                } else {
                    return redirect()->back()->with('message', 'Password salah ');
                }
            } else {
                return redirect()->back()->with('message', 'Username salah ');
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'alert' => 'danger']);
        }
    }
    public function logout(Request $request)
    {
        if (session('user-session')) {

            Cart::where('id_user', session('user-session')->id)->update([
                'status' => '0'
            ]);
            Dumy::where('id_user', session('user-session')->id)->delete();
        }
        $request->session()->forget('isCustomerLogin');
        $request->session()->forget('user-session');
        $request->session()->flush();
        return redirect('/');
    }
    public function register(Request $request)
    {
        if (isset($_COOKIE[env('STORE_NAME')])) {
            $data_reff = json_decode($_COOKIE[env('STORE_NAME')]);
            session(['data_refferal' => $data_reff]);
        }
        return view('pages.register');
    }
    public function forgot_password(Request $request)
    {
        return view('pages.forgot-password');
    }
    public function proses_registrasi(Request $request)
    {


        $request->validate([
            'username' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required'
        ]);
        try {
            $cek = Users::where('email', $request->email)
                ->whereOr('phone', $request->phone)->first();
            if ($cek) {
                return redirect()->back()->with(['message' => 'Alamat Email atau Nomor Handphone sudah terdaftar', 'alert' => 'danger']);
            }
            $hasil = Users::create([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'refferal' => session('data_refferal')->username,
                'refferal_id' => session('data_refferal')->member_id
            ]);
            if ($hasil) {
                $id_user = $hasil->id;
                $username = $request->username;
                $password = $request->password;
                $nama = $request->name;
                $email = $request->email;
                $phone = $request->phone;

                $url_konfirmasi = encrypt($email . '&' . $id_user);
                $data_user_registered = [
                    'username' => $username,
                    'password' => $password,
                    'nama' => $nama,
                    'email' => $email,
                    'phone' => $phone,
                    'id_user' => $id_user,
                    'refferal' => session('data_refferal')->username,
                    'hp_refferal' => session('data_refferal')->hp,
                    'url_konfirmasi' => $email . "&" . $id_user,

                ];

                $isi_email = '  <table cellpadding=4 cellspacing=0 border=1 align="center" style="width:500px;margin:20px auto">
                    <tr><td>Username </td><td>' . $username . '</td></tr>
                    <tr><td>Password </td><td>' . $password . '</td></tr>
                    <tr><td>Nama Lengkap </td><td>' . $nama . '</td></tr>
                    <tr><td>Alamat Email </td><td>' . $email . '</td></tr>
                    <tr><td>No Handphone </td><td>' . $phone . '</td></tr>
                    <tr><td>Refferal </td><td>' . session('data_refferal')->username . '</td></tr>
                    <tr><td>No HP Refferal </td><td>' . session('data_refferal')->hp . '</td></tr>
                </table>
                
                <h4 class="nunito bolder mb-4 text-center">Silahkan lakukan Konfirmasi dengan mengklik tombol <a href="' . env('APP_DOMAIN') . '/confirm/' . $url_konfirmasi . '" style="text-decoration:none;color:red;" target="_blank">Konfirmasi</a> untuk 
                    mengkonfirmasi proses pendaftaran Anda  </h4>';
                $headers  = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                $headers .= 'From: <no-reply@' . env('APP_DOMAIN') . '>' . "\r\n";

                $kirim_email = mail($email, 'Proses Pendaftaran Anda di ' . env('STORE_NAME'), $isi_email, $headers);

                return redirect('/register/success')->with(['data_user_registered' => $data_user_registered]);
            } else {
                return redirect()->back()->with(['message' => 'Proses Registrasi Gagal', 'alert' => 'warning'])->withInput;
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => 'Proses Registrasi Gagal', 'alert' => 'danger'])->withInput;
        }
    }
    public function register_sukses(Request $req)
    {
        $data = session('data_user_registered');
        $nama = $data['nama'];
        $url_konfirmasi = encrypt($data['email'] . "&" . $data['id_user']);
        return view('pages.registrasi-sukses', compact('url_konfirmasi', 'data', 'nama'));
    }
    public function proses_konfirmasi(Request $req)
    {
        $dt = decrypt($req->id);
        if (!empty($dt)) {
            $a_dt = explode("&", $dt);
            $id = $a_dt[1];
            $email = $a_dt[0];
            $cek = Users::find($id);
            if ($cek) {
                $hasil = $cek->update([
                    'email_verified_at' => now()
                ]);
                if ($hasil) {
                    $user = Users::find($id);
                    session(['isCustomerLogin' => true]);

                    session(['user-session' => $user]);
                    return redirect('/');
                }
            } else {
                return redirect('/')->with(['message' => 'Proses Konfirmasi gagal,silahkan hubungin web admin', 'alert' => 'danger']);
            }
        }
    }
}
