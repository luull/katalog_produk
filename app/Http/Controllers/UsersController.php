<?php

namespace App\Http\Controllers;

use App\Contact;
use App\User;
use App\Users;
use App\City;
use App\Province;
use App\Subdistrict;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
Use Alert;
class UsersController extends Controller
{
    public function index()
    {
        if (empty(session('user-session'))) {
            return redirect('/');
        }
        if (empty(session('user-session')->id)) {
            return redirect('/');
        }
        $data = User::where('id', session('user-session')->id)->first();
        $countcontact = Contact::where('id_user', session('user-session')->id)->first();
        // dd(session('user-session')->id);
        $contact = Contact::select('contact.*', 'contact.id as idny', 'city.*', 'subdistrict.*')
            ->join('city', 'city.city_id', '=', 'contact.city')
            ->join('subdistrict', 'subdistrict.subdistrict_id', '=', 'contact.subdistrict')
            ->where('contact.id_user', '=', session('user-session')->id)
            ->orderBy('status', 'DESC')
            ->get();
        $getuser = User::where('id', session('user-session')->id)->first();
        // $contact = Contact::where('id_user', session('user-session')->id)->get();
        $province = Province::get();
        $city = City::get();
        $subdistrict = Subdistrict::get();
        return view('users.dashboard', compact('data', 'contact', 'province', 'city', 'subdistrict', 'countcontact', 'getuser'));
    }
    public function updateavatar(Request $request)
    {
        $this->validate(
            $request,
            [
                'photo' => 'mimes:jpeg,png,jpg,gif |max:2096',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'mimes' => 'Only jpeg, png are allowed.'
            ]
        );
        try {

            $photo = '';
            if ($request->hasfile('photo')) {
                $photoName = time() . '.' . $request->photo->extension();
                $uid = session('user-session')->google_id;
                $request->photo->move(public_path($uid . '/images'), $photoName);
                $photo = "$uid/images/$photoName";
            } else {
                $photo = $request->default;
            }
            $usr = Users::find($request->id);
            $hsl = $usr->update([
                'photo' => $photo,
            ]);
            if ($hsl) {
                Alert::success('Avatar berhasil diubah');
                return redirect()->back();
            } else {
                Alert::error('Avatar gagal diubah');
                return redirect()->back();
            }
        } catch (Exception $e) {
            Alert::error('Avatar gagal diubah '. $e->getMessage());
            return redirect()->back();
        }
    }
    public function addcontact(Request $request)
    {
        if (empty(session('user-session'))) {
            return redirect('/');
        }
        if (empty(session('user-session')->id)) {
            return redirect('/');
        }
        try {
            $request->validate([
                'category' => 'required',
                'propinsi' => 'required',
                'kota' => 'required',
                'kecamatan' => 'required',
                'phone' => 'required',
                'alamat' => 'required',
                'penerima' => 'required'
            ]);
            if (substr($request->phone, 0, 2) != '62') {
                $phonenum = "62" . substr($request->phone, 1);
            } else {
                $phonenum = $request->phone;
            }
            $hsl = Contact::create([
                'id_user' => session('user-session')->id,
                'name' => $request->penerima,
                'category' => $request->category,
                'province' => $request->propinsi,
                'city' => $request->kota,
                'subdistrict' => $request->kecamatan,
                'phone' => $phonenum,
                'address' => $request->alamat,
                'kd_pos' => $request->kd_pos,
            ]);
            if ($hsl) {
                Alert::success('Data berhasil ditambahkan');
                return redirect()->back();
            } else {
                Alert::error('Data gagal ditambahkan');
                return redirect()->back();
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    public function updatecontact(Request $request)
    {
        if (empty(session('user-session'))) {
            return redirect('/');
        }
        if (empty(session('user-session')->id)) {
            return redirect('/');
        }
        try {
            $request->validate([
                'edit_category' => 'required',
                'edit_propinsi' => 'required',
                'edit_kota' => 'required',
                'edit_kecamatan' => 'required',
                'edit_phone' => 'required',
                'edit_alamat' => 'required',
                'edit_penerima' => 'required'
            ]);
            if (substr($request->edit_phone, 0, 2) != '62') {
                $phonenum = "62" . substr($request->edit_phone, 1);
            } else {
                $phonenum = $request->edit_phone;
            }
            $hsl = Contact::find($request->contact_id)->update([
                'penerima' => $request->edit_penerima,
                'category' => $request->edit_category,
                'province' => $request->edit_propinsi,
                'city' => $request->edit_kota,
                'subdistrict' => $request->edit_kecamatan,
                'phone' => $phonenum,
                'address' => $request->edit_alamat,
                'kd_pos' => $request->edit_kd_pos,
            ]);
            if ($hsl) {
                Alert::success('Data berhasil ditambahkan');
                return redirect()->back();
            } else {
                Alert::error('Data gagal ditambahkan');
                return redirect()->back();
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    public function updatestatus(Request $request)
    {
        if (empty(session('user-session'))) {
            return redirect('/');
        }
        if (empty(session('user-session')->id)) {
            return redirect('/');
        }
        try {
            Contact::where('status', '=', 1)->where('pick', '=', 1)->update([
                'status' => '0',
                'pick' => '0',
            ]);
            $hsl = Contact::where('id', $request->id)->update([
                'status' => '1',
                'pick' => '1',
            ]);
            if ($hsl) {
                Alert::success('Alamat berhasil diaktifkan');
                return redirect()->back();
            } else {
                Alert::error('Alamat gagal diaktifkan');
                return redirect()->back();
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    public function find(Request $req)
    {
        if (empty(session('user-session'))) {
            return redirect('/');
        }
        if (empty(session('user-session')->id)) {
            return redirect('/');
        }
        $hsl = Contact::find($req->id);
        if ($hsl) {
            return response()->json($hsl);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan', 'error' => true]);
        }
    }
    public function delete(Request $req)
    {
        if (empty(session('user-session'))) {
            return redirect('/');
        }
        if (empty(session('user-session')->id)) {
            return redirect('/');
        }
        $hsl = Contact::find($req->id)->delete();
        if ($hsl) {
            Alert::success('Data berhasil dihapus');
            return redirect()->back();
        } else {
            Alert::error('Data gagal dihapus');
            return redirect()->back();
        }
    }
}
