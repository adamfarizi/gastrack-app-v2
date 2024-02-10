<?php

namespace App\Http\Controllers;

use App\Models\Penarikanbop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PenarikanController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Penarikan BOP';

        $penarikans = Penarikanbop::where('status_penarikan', 'Belum Tarik')
            ->with('sopir', 'admin')
            ->get();

        // Mengambil riwayat penarikan terbaru dengan mengurutkan berdasarkan tanggal penarikan secara menurun
        $perPage_riwayat = $request->input('perPage_riwayat', 10);
        $riwayat_penarikans = Penarikanbop::where('status_penarikan', 'Sudah Tarik')
            ->with('sopir', 'admin')
            ->orderBy('tanggal_penarikan', 'desc') // Urutkan berdasarkan tanggal penarikan terbaru
            ->paginate($perPage_riwayat, ['*'], 'riwayat_penarikans')
            ->appends(request()->query());

        return view('auth.penarikan.penarikan', [
            'penarikans' => $penarikans,
            'riwayat_penarikans' => $riwayat_penarikans,
            'perPage_riwayat' => $perPage_riwayat,
        ], $data);
    }


    public function pengambilan_bop($id_penarikan, Request $request)
    {

        $penarikan = Penarikanbop::where('id_penarikan', $id_penarikan)->first();

        if (!$penarikan) {
            Session::flash('error', 'Data sopir tidak ditemukan!');
            return response()->json(['error' => true]);
        } else {
            $penarikan->tanggal_pengambilan = now();
            $penarikan->status_penarikan = "Sudah Tarik";
            $penarikan->id_admin = Auth::user()->id_admin;
            $penarikan->save();

            return redirect()->back()->with('success', 'Penarikan berhasil, Silahkan Cetak Kwitansi!');
        }
    }
}
