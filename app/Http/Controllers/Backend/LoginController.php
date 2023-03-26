<?php

namespace App\Http\Controllers\Backend;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view("backend.pages.login");
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        session(['isBackendLogin' => false]);

        $uid = $request->username;
        $pwd = $request->password;
        $data = Admin::where('username', $uid)->first();
        if ($data) {
            if (Hash::check($pwd, $data->password)) {
                session(['backend-session' => $data]);
                session(['isBackendLogin' => true]);

                return redirect('/backend/dashboard');
            } else {
                return redirect()->back()->with('message', 'Password salah ');
            }
        } else {
            return redirect()->back()->with('message', 'Username salah ');
        }
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/backend/login')->with('message', 'Berhasil logout');
    }
}
