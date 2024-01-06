<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index($id_admin)
    {
        $data['title'] = 'Profil';

        $admin = User::find($id_admin);

        return view('auth.profil.profil', [
            'admin' => $admin,
        ], $data);
    }

    public function edit_profil_action($id_admin, Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $admin = User::find($id_admin);
        $admin->nama = $request->input('nama');
        $admin->email = $request->input('email');
        $admin->save();

        return redirect()->back()->with('success', 'Data berhasil diubah !');
    }

    public function edit_password_action($id_admin, Request $request)
    {
        $request->validate([
            'old_password' => [
                'required',
                function ($attribute, $value, $fail) use ($id_admin) {
                    $admin = User::find($id_admin);

                    if (!Hash::check($value, $admin->password)) {
                        $fail('Password lama salah !');
                    }
                },
            ],
            'new_password' => 'required|confirmed',
        ], [
            'old_password.required' => 'Masukkan password lama !',
            'new_password.required' => 'Masukkan password baru !',
            'new_password.confirmed' => 'Konfirmasi password tidak sama !',
        ]);

        $admin = User::find($id_admin);
        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return redirect()->back()->with('success', 'Password berhasil diubah !');
    }
}
