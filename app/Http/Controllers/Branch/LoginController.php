<?php

namespace App\Http\Controllers\Branch;

use App\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
Use Alert;
class LoginController extends Controller
{
    public function index()
    {
        return view("branch.pages.login");
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        session(['isBranchLogin' => false]);

        $uid = $request->username;
        $pwd = $request->password;
        $data = Branch::where('branch_id', $uid)->first();
        if ($data) {
            if (Hash::check($pwd, $data->password)) {
                session(['branch-session' => $data]);
                session(['isBranchLogin' => true]);
                Alert::success('Berhasil login');
                return redirect('/branch/dashboard');
            } else {
                Alert::error('Password salah');
                return redirect()->back();
            }
        } else {
            Alert::error('Username salah');
            return redirect()->back();
        }
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        Alert::success('Berhasil logout');
        return redirect('/branch/login');
    }
    public function dashboard()
    {
        $count1 = 0;
        $count2 = 0;
        $count3 = 0;
        $count4 = 0;
        $count5 = 0;
        $count6 = 0;
        $count7 = 0;
        return view('branch.pages.dashboard', compact('count1', 'count2', 'count3', 'count4', 'count5', 'count6', 'count7'));
    }
}
