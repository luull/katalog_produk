<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\File;
use Exception;
use App\User;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {

                Auth::login($finduser);
                session(['isCustomerLogin' => true]);
                session(['user-session' => $finduser]);
                return redirect('/');
            } else {
                $a_usr = explode("@", $user->email);
                $username = $a_usr[0];
                $newUser = User::create([
                    'username' => $username,
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' =>  bcrypt('123456dummy')
                ]);

                Auth::login($newUser);
                session(['user-session' => $finduser]);
                File::makeDirectory(public_path('user') . '/' . $user->id, 0777, true);
                File::makeDirectory(public_path('user/' . $user->id) . '/images', 0777, true);
                return redirect('/');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
