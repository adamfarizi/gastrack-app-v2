<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login()
    {
        $data['title'] = 'Masuk';
        return view('guest.login', $data);
    }

    public function login_action(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            if (Auth::user() && (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin')) {
                $request->session()->regenerate();
                return redirect('beranda');
            } else {
                return redirect('/')->withErrors('Anda bukan admin!');
            }
        } else {
            return redirect('/')->withErrors('Email dan Password anda salah!')->withInput();
        }
    }

    public function signup()
    {
        $data['title'] = 'Register';
        return view('guest.signup', $data);
    }

    public function signup_action(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:admin',
            'password' => 'required',
            'konfirmasi_password' => 'required|same:password',
        ]);
        $admin = new User([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role ?? 'Admin',
            'password' => Hash::make($request->password),
        ]);
        $admin->save();
        return redirect('/')->with('success', 'Akun berhasil didaftarkan, silahkan login!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
