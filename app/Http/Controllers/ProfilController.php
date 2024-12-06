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
            'new_password' => 'required|confirmed|min:8',
        ], [
            'new_password.required' => 'Masukkan password baru!',
            'new_password.confirmed' => 'Konfirmasi password tidak sama!',
            'new_password.min' => 'Password harus memiliki minimal 8 karakter!',
        ]);

        // Cari admin berdasarkan ID
        $admin = User::find($id_admin);

        // Perbarui password dengan password baru
        $admin->password = Hash::make($request->new_password);

        // Simpan perubahan
        $admin->save();

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }
}
