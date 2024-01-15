<?php

namespace App\Http\Controllers;

use App\Models\Sopir;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SopirController extends Controller
{
    public function index()
    {
        $data['title'] = 'Sopir & Kendaraan';

        // Navbar
        $total_sopir = Sopir::count();
        $total_kendaraan = Mobil::count();

        $sopir = Sopir::all();
        $kendaraan = Mobil::all();

        return view('auth.sopir.sopir', [
            'total_sopir' => $total_sopir,
            'total_kendaraan' => $total_kendaraan,
            'sopirs' => $sopir,
            'kendaraans' => $kendaraan,
        ], $data);
    }

    public function tambah_sopir_action(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:sopir',
            'no_hp' => 'required',
            'password' => 'required',
            'konfirmasi_password' => 'required|same:password',
        ]);

        $sopir = new Sopir([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
        ]);

        $sopir->save();

        return redirect()->back()->with('success', 'Data berhasil ditambah !');
    }

    public function edit_sopir($id_sopir)
    {
        $data['title'] = 'Edit Sopir';
        $sopir = Sopir::find($id_sopir);

        return view('auth.sopir.edit.edit_sopir', [
            'sopir' => $sopir
        ], $data);
    }

    public function edit_sopir_action($id_sopir, Request $request)
    {

        if ($request->old_password == null) {
            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'no_hp' => 'required|string|max:15',
            ]);

            $sopir = Sopir::find($id_sopir);
            $sopir->nama = $request->input('nama');
            $sopir->email = $request->input('email');
            $sopir->no_hp = $request->input('no_hp');
            $sopir->save();

            return redirect()->route('sopir')->with('success', 'Data berhasil diubah !');
        } else {
            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'no_hp' => 'required|string|max:15',
                'old_password' => [
                    'required',
                    function ($attribute, $value, $fail) use ($id_sopir) {
                        $sopir = Sopir::find($id_sopir);

                        if (!Hash::check($value, $sopir->password)) {
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

            $sopir = Sopir::find($id_sopir);
            $sopir->nama = $request->input('nama');
            $sopir->email = $request->input('email');
            $sopir->no_hp = $request->input('no_hp');
            $sopir->password = Hash::make($request->new_password);
            $sopir->save();

            return redirect()->route('sopir')->with('success', 'Data & Password berhasil diubah !');
        }
    }

    public function edit_sopir_status($id_sopir)
    {

        $sopir = Sopir::find($id_sopir);

        if ($sopir->status_sopir === 'aktif') {
            $sopir->status_sopir = 'tidak aktif';
            $sopir->save();
            return redirect()->back()->with('error', 'Status sopir tidak aktif !');
        } else {
            $sopir->status_sopir = 'aktif';
            $sopir->save();
            return redirect()->back()->with('success', 'Status sopir aktif !');
        }
    }

    public function hapus_sopir_action($id_sopir)
    {

        $sopir = Sopir::find($id_sopir);
        $sopir->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus !');
    }

    public function tambah_kendaraan_action(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'plat' => 'required',
            'vit' => 'required',
            'jenis_kendaraan' => 'required',
        ]);

        $kendaraan = new Mobil([
            'identitas_mobil' => $request->nama,
            'nopol_mobil' => $request->plat,
            'vit_mobil' => $request->vit,
            'jenis_mobil' => $request->jenis_kendaraan,
        ]);

        $kendaraan->save();

        return redirect()->back()->with('success', 'Data berhasil ditambah !');
    }

    public function edit_kendaraan($id_mobil)
    {
        $data['title'] = 'Edit kendaraan';
        $kendaraan = Mobil::find($id_mobil);

        return view('auth.sopir.edit.edit_kendaraan', [
            'kendaraan' => $kendaraan
        ], $data);
    }

    public function edit_kendaraan_action($id_mobil, Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'plat' => 'required|string|max:255',
            'vit' => 'required|int|max:255',
            'jenis_kendaraan' => 'required|string|max:15',
        ]);

        $kendaraan = Mobil::find($id_mobil);
        $kendaraan->identitas_mobil = $request->input('nama');
        $kendaraan->nopol_mobil = $request->input('plat');
        $kendaraan->vit_mobil = $request->input('vit');
        $kendaraan->jenis_mobil = $request->input('jenis_kendaraan');
        $kendaraan->save();

        return redirect()->back()->with('success', 'Data berhasil diubah !');
    }

    public function edit_kendaraan_status($id_kendaraan)
    {

        $kendaraan = Mobil::find($id_kendaraan);

        if ($kendaraan->status_mobil === 'aktif') {
            $kendaraan->status_mobil = 'tidak aktif';
            $kendaraan->save();
            return redirect()->back()->with('error', 'Status mobil tidak aktif !');
        } else {
            $kendaraan->status_mobil = 'aktif';
            $kendaraan->save();
            return redirect()->back()->with('success', 'Status mobil aktif !');
        }
    }

    public function hapus_kendaraan_action($id_mobil)
    {

        $kendaraan = Mobil::find($id_mobil);
        $kendaraan->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus !');
    }

}
