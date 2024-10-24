<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Gas;
use App\Models\User;
use App\Models\Mobil;
use App\Models\Sopir;
use App\Models\Pesanan;
use App\Models\Tagihan;
use App\Models\Transaksi;
use App\Models\Pengiriman;
use Illuminate\Support\Str;
use App\Models\Penarikanbop;
use Illuminate\Http\Request;
use App\Events\GasMasukEvent;
use App\Events\GasKeluarEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class ApiSopirController extends Controller
{
    public function index()
    {
        $dateupdate = Sopir::all();

        if ($dateupdate) {
            return new PostResource(true, 'Get Berhasil', $dateupdate);
        } else {
            return response()->json("Not Found 404");
        }
    }

    public function login_action(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $sopir = Sopir::where('email', $request->email)->first();

        if (!$sopir) {
            return response()->json([
                'success' => false,
                'message' => 'Akun tidak terdaftar!',
            ], 422);
        }

        // Verifikasi password
        if (password_verify($request->password, $sopir->password)) {
            $token = $sopir->createToken('myappToken')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'datauser' => $sopir,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Password Anda salah!!',
            ], 422);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            // Revoke the user's access tokens
            $user->tokens()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil.',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal logout. Pengguna tidak ditemukan.',
            ], 401);
        }
    }

    public function getDataPengiriman(string $id)
    {
        Carbon::setLocale('id');
        $pengiriman = Pengiriman::where('status_pengiriman', 'Dikirim')
            ->where('id_sopir', $id)
            ->join('pesanan', 'pengiriman.id_pesanan', '=', 'pesanan.id_pesanan')
            ->join('transaksi', 'pesanan.id_transaksi', '=', 'transaksi.id_transaksi')
            ->join('pelanggan', 'transaksi.id_pelanggan', '=', 'pelanggan.id_pelanggan')
            ->orderByDesc('pengiriman.created_at');

        if (!$pengiriman->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada pesanan!',
            ], 422);
        } else {
            $data = $pengiriman
                ->select(
                    'pengiriman.id_pengiriman',
                    'transaksi.resi_transaksi AS resi',
                    'pelanggan.koordinat',
                    'pelanggan.nama_perusahaan',
                    'pelanggan.alamat AS alamat_perusahaan',
                    'pesanan.jumlah_bar',
                    'pesanan.jumlah_m3',
                    'pesanan.tanggal_pesanan AS tanggal_pemesanaan'
                )->first();

            if ($data) {
                $formattedTanggal = Carbon::parse($data->tanggal_pemesanaan)->isoFormat('DD MMMM YYYY');
                $data->tanggal_pemesanaan = $formattedTanggal;
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil ditemukan',
                    'data' => $data,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan!',
                ], 422);
            }
        }
    }

    public function getDataDetailPengiriman(string $id)
    {
        Carbon::setLocale('id');

        $pengiriman = Pengiriman::where('id_pengiriman', $id);

        if (!$pengiriman->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 422);
        } else {
            $data = $pengiriman
                ->select(
                    'kapasitas_gas_masuk',
                    'bukti_gas_masuk',
                    'waktu_pengiriman',
                    'waktu_diterima',
                    'kapasitas_gas_keluar',
                    'bukti_gas_keluar',
                    'status_pengiriman',
                    'sisa_gas'
                )->first();

            if ($data) {
                $formattedTanggalpengiriman = Carbon::parse($data->waktu_pengiriman)->isoFormat('DD MMMM YYYY');
                $formattedTanggalditerima = Carbon::parse($data->waktu_diterima)->isoFormat('DD MMMM YYYY');

                $data->waktu_pengiriman = $formattedTanggalpengiriman;
                $data->waktu_diterima = $formattedTanggalditerima;
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil ditemukan',
                    'data' => $data,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan!',
                ], 422);
            }
        }
    }

    public function gas_masuk(Request $request, $id_pengiriman)
    {
        // Validasi request
        $request->validate([
            'bukti_gas_masuk' => 'required|image|mimes:jpeg,jpg,png',
        ]);

        // Ambil data pengiriman sebelumnya
        $pengiriman_lama = Pengiriman::where('id_pengiriman', '<', $id_pengiriman)
            ->whereNull('bukti_gas_keluar')
            ->orderBy('id_pengiriman', 'desc')
            ->first();

        if (!$pengiriman_lama) {
            // Ambil pengiriman sekarang
            $pengiriman_baru = Pengiriman::where('id_pengiriman', $id_pengiriman)
                ->first();

            if (!$pengiriman_baru) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan!',
                ], 422);
            }

            if ($request->hasFile('bukti_gas_masuk')) {
                $file = $request->file('bukti_gas_masuk');
                $nomor_resi = preg_replace('/[^0-9]/', '', $pengiriman_baru->kode_pengiriman);
                $fileName = $nomor_resi . "_" . $file->getClientOriginalName();
                $file->move(public_path('img/GasMasuk'), $fileName);

                $pengiriman_baru->update([
                    'bukti_gas_masuk' => $fileName,
                ]);
            }

            $pengiriman_baru->waktu_pengiriman = now();
            $pengiriman_baru->save();

            return response()->json([
                'success' => true,
                'message' => 'Data pengiriman berhasil diupdate'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Masukkan Gas Keluar pesanan sebelumnya dahulu!',
            ], 422);
        }
    }

    public function gas_keluar(Request $request, $id_pengiriman)
    {
        // Validasi request
        $request->validate([
            'bukti_gas_keluar' => 'required|image|mimes:jpeg,jpg,png',
        ]);

        // Ambil data pengiriman berdasarkan ID
        $pengiriman = Pengiriman::where('id_pengiriman', $id_pengiriman)
            ->join('sopir', 'pengiriman.id_sopir', '=', 'sopir.id_sopir')
            ->join('mobil', 'pengiriman.id_mobil', '=', 'mobil.id_mobil')
            ->first();

        if (!$pengiriman) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        }

        $pengiriman->waktu_diterima = now();

        if ($request->hasFile('bukti_gas_keluar')) {
            $file = $request->file('bukti_gas_keluar');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('img/GasKeluar'), $fileName);

            $pengiriman->update([
                'bukti_gas_keluar' => $fileName,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data pengiriman berhasil diupdate',
        ], 200);
    }

    public function detail_sopir(string $id)
    {
        $sopir = Sopir::where('id_sopir', $id)->first();

        if (empty($sopir)) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        } else {
            $sopir->makeHidden(['password']);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditemukan',
                'datauser' => $sopir,
            ], 200);
        }
    }

    public function edit_index(string $id)
    {
        $sopir = Sopir::where('id_sopir', $id)->first();

        if (empty($sopir)) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        } else {
            $sopir->no_hp = $this->hidePhoneNumber($sopir->no_hp);
            $sopir->email = $this->encryptEmail($sopir->email);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditemukan',
                'datauser' => $sopir,
            ], 200);
        }
    }

    public function edit_name(string $id, Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Lanjutkan dengan operasi lain jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->validator->errors()->all(),
            ], 422);
        }

        $sopir = Sopir::find($id);
        if (empty($sopir)) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        }

        $sopir->nama = $request->input('name');
        $sopir->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah',
            'datauser' => $sopir,
        ], 200);
    }

    public function edit_email(string $id, Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|max:255',
            ]);

            // Check if the new email already exists
            $existingEmail = Sopir::where('email', $request->input('email'))->first();
            if ($existingEmail) {
                if ($existingEmail['id_sopir'] == $id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak melakukan perubahan email.',
                    ], 422);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Email sudah terdaftar.',
                    ], 422);
                }
            }

            $sopir = Sopir::find($id);
            if (empty($sopir)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan!',
                ], 422);
            }

            $sopir->email = $request->input('email');
            $sopir->save();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diubah',
                'datauser' => $sopir,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->validator->errors()->all(),
            ], 422);
        }
    }

    public function edit_no_hp(string $id, Request $request)
    {
        try {
            $request->validate([
                'no_hp' => 'required|string|max:15',
            ]);

            // Lanjutkan dengan operasi lain jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->validator->errors()->all(),
            ], 422);
        }

        $sopir = Sopir::find($id);
        if (empty($sopir)) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        }

        $sopir->no_hp = $request->input('no_hp');
        $sopir->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah',
            'datauser' => $sopir,
        ], 200);
    }

    public function edit_password(string $id, Request $request)
    {
        try {
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required',
                'new_password_confirmation' => 'required',
            ]);

            // Lanjutkan dengan operasi lain jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->validator->errors()->all(),
            ], 422);
        }

        $old_password = $request->input('old_password');
        $passwordInDatabase = Sopir::where('id_sopir', $id)->pluck('password')->first();

        if (Hash::check($old_password, $passwordInDatabase)) {
            $new_password = $request->input('new_password');
            $new_password_confirmation = $request->input('new_password_confirmation');

            if ($new_password == $new_password_confirmation) {
                $sopir = Sopir::find($id);
                $sopir->password = Hash::make($new_password); // Menghash password baru
                $sopir->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Password berhasil diubah!',
                    'datauser' => $sopir,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Konfirmasi password tidak cocok!',
                ], 422);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Password lama tidak cocok!',
            ], 422);
        }
    }

    private function hidePhoneNumber($phoneNumber)
    {
        // Menyembunyikan karakter kecuali 4 digit terakhir
        $visibleDigits = 4;
        $length = strlen($phoneNumber);

        if ($length <= $visibleDigits) {
            return $phoneNumber;
        }

        $hiddenPart = str_repeat('*', $length - $visibleDigits);
        $visiblePart = substr($phoneNumber, -$visibleDigits);

        return $hiddenPart . $visiblePart;
    }

    private function encryptEmail($email)
    {
        $emailParts = explode('@', $email);

        if (count($emailParts) === 2) {
            $username = $emailParts[0];
            $domain = $emailParts[1];

            // Enkripsi huruf di tengah
            $encryptedUsername = $this->encryptMiddle($username);

            // Gabungkan kembali
            $encryptedEmail = $encryptedUsername . '@' . $domain;

            return $encryptedEmail;
        }

        return $email;
    }

    private function encryptMiddle($text)
    {
        $length = strlen($text);

        if ($length <= 2) {
            return $text;
        }

        $start = substr($text, 0, 1);
        $end = substr($text, -1);

        $middle = str_repeat('*', $length - 2);

        return $start . $middle . $end;
    }

    public function penarikanbop($id_sopir, Request $request)
    {
        $request->validate([
            'jumlah_penarikan' => 'required|numeric',
        ]);

        $jumlah_penarikan = $request->input('jumlah_penarikan');
        $sopir = Sopir::where('id_sopir', $id_sopir)->first();

        if ($sopir->bop_sopir < $jumlah_penarikan || $sopir->bop_sopir == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Saldo anda tidak cukup!',
            ], 422);
        } elseif ($jumlah_penarikan <= 9999) {
            return response()->json([
                'success' => false,
                'message' => 'Penarikan minimal Rp.10,000!',
            ], 422);
        } else {
            $sopir->bop_sopir = $sopir->bop_sopir - $jumlah_penarikan;
            $sopir->save();

            $kode_penarikan = 'GTK|TRK-' . now()->format('YmdHis') . Str::random(2);
            $penarikan = new Penarikanbop([
                'kode_penarikan' => $kode_penarikan,
                'tanggal_penarikan' => now(),
                'jumlah_penarikan' => $jumlah_penarikan,
                'status_penarikan' => 'Belum Tarik',
                'id_sopir' => $id_sopir, // Menggunakan $id_sopir dari parameter
            ]);
            $penarikan->save();

            return response()->json([
                'success' => true,
                'message' => 'Penarikan berhasil!',
                'kode_penarikan' => $penarikan->kode_penarikan,
                'id_penarikan' => $penarikan->id_penarikan,
                'sisa_saldo' => $sopir->bop_sopir,
            ], 200);
        }
    }

    public function riwayatpenarikanbop(Request $request, $id_sopir)
    {
        $penarikan = Penarikanbop::where('id_sopir', $id_sopir)
            ->with('admin')
            ->get();

        if ($penarikan->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada riwayat penarikan!',
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Riwayat penarikan ditemukan!',
                'riwayat' => $penarikan,
            ], 200);
        }
    }

    public function detailriwayatpenarikanbop(Request $request, $id_riwayat)
    {
        $penarikan = Penarikanbop::where('id_penarikan', $id_riwayat)
            ->get();

        if ($penarikan->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada detail penarikan!',
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Detail penarikan ditemukan!',
                'data' => $penarikan,
            ], 200);
        }
    }

    public function getDataPengirimanAll()
    {
        $pengiriman = Pengiriman::where('status_pengiriman', 'Proses')
            ->whereNull('id_sopir')
            ->whereNull('id_mobil')
            ->join('pesanan', 'pengiriman.id_pesanan', '=', 'pesanan.id_pesanan')
            ->join('transaksi', 'pesanan.id_transaksi', '=', 'transaksi.id_transaksi')
            ->join('pelanggan', 'transaksi.id_pelanggan', '=', 'pelanggan.id_pelanggan');

        if (!$pengiriman->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada pesanan!',
            ], 422);
        } else {
            $data = $pengiriman
                ->select(
                    'pengiriman.id_pengiriman',
                    'transaksi.resi_transaksi AS resi',
                    'pelanggan.koordinat',
                    'pelanggan.nama_perusahaan',
                    'pelanggan.alamat AS alamat_perusahaan',
                    'pesanan.tanggal_pesanan AS tanggal_pemesanaan',
                    'pesanan.bukti_pesanan',
                    'pesanan.deskripsi_pesanan',
                )
                ->orderByDesc('pengiriman.created_at')
                ->get();

            if ($data) {
                $pengiriman->each(function ($item) {
                    $item->tanggal_pemesanaan = Carbon::parse($item->tanggal_pemesanaan)->isoFormat('DD MMMM YYYY');
                });
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil ditemukan',
                    'data' => $data,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan!',
                ], 422);
            }
        }
    }

    public function getDataMobilFree()
    {
        $mobil = Mobil::where('ketersediaan_mobil', 'tersedia')
            ->where('status_mobil', 'aktif')
            ->get();

        if ($mobil->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada mobil tersedia!',
            ], 422);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditemukan',
                'data' => $mobil,
            ], 200);
        }
    }

    public function selectPengiriman(Request $request, $id_pengiriman)
    {
        // Validasi request
        $request->validate([
            'id_sopir' => 'required|integer|exists:sopir,id_sopir',
            'id_mobil' => 'required|integer|exists:mobil,id_mobil',
        ]);

        // Ambil data pengiriman berdasarkan ID
        $pengiriman = Pengiriman::where('id_pengiriman', $id_pengiriman)
            ->whereNull('id_sopir')
            ->whereNull('id_mobil')
            ->with('pesanan.transaksi.pelanggan')
            ->first();

        if (!$pengiriman) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        } else {
            $sopir = Sopir::where('id_sopir', $request->id_sopir)
                ->where('ketersediaan_sopir', 'tersedia')
                ->where('status_sopir', 'aktif')
                ->first();

            $mobil = Mobil::where('id_mobil', $request->id_mobil)
                ->where('ketersediaan_mobil', 'tersedia')
                ->where('status_mobil', 'aktif')
                ->first();

            if (!$mobil || !$sopir) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sopir dan Mobil tidak tersedia!',
                ], 422);
            } else {
                $bop_pelanggan = $pengiriman->pesanan->transaksi->pelanggan->bop_pelanggan;

                $sopir->ketersediaan_sopir = 'tidak tersedia';
                $sopir->bop_sopir = $sopir->bop_sopir + $bop_pelanggan;
                $sopir->save();

                $mobil->ketersediaan_mobil = 'tidak tersedia';
                $mobil->save();

                $pengiriman->status_pengiriman = 'Dikirim';
                $pengiriman->id_sopir = $request->id_sopir;
                $pengiriman->id_mobil = $request->id_mobil;
                $pengiriman->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Data pengiriman berhasil diupdate',
                    'data' => $pengiriman,
                ], 200);
            }
        }
    }

    public function uploadNotaPengisian(Request $request, $id_pengiriman)
    {
        // Validasi request
        $request->validate([
            'bukti_nota_pengisian' => 'required|image|mimes:jpeg,jpg,png',
        ]);

        // Ambil data pengiriman berdasarkan ID
        $pengiriman = Pengiriman::where('id_pengiriman', $id_pengiriman)
            ->join('sopir', 'pengiriman.id_sopir', '=', 'sopir.id_sopir')
            ->join('mobil', 'pengiriman.id_mobil', '=', 'mobil.id_mobil')
            ->first();

        if (!$pengiriman) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        }

        if ($request->hasFile('bukti_nota_pengisian')) {
            $file = $request->file('bukti_nota_pengisian');
            $nomor_resi = preg_replace('/[^0-9]/', '', $pengiriman->kode_pengiriman);
            $fileName = $nomor_resi . "_" . $file->getClientOriginalName();
            $file->move(public_path('img/NotaPengisian'), $fileName);

            $pengiriman->update([
                'bukti_nota_pengisian' => $fileName,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data pengiriman berhasil diupdate',
            'data' => $pengiriman->bukti_nota_pengisian,
        ], 200);
    }

    public function ubahStatusSopirMobil(Request $request, $id_pengiriman)
    {
        // Ambil data pengiriman berdasarkan ID
        $pengiriman = Pengiriman::where('id_pengiriman', $id_pengiriman)
            ->join('sopir', 'pengiriman.id_sopir', '=', 'sopir.id_sopir')
            ->join('mobil', 'pengiriman.id_mobil', '=', 'mobil.id_mobil')
            ->first();

        if (!$pengiriman) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        } else {

            $status_sopir = $pengiriman->sopir->ketersediaan_sopir;
            $status_mobil = $pengiriman->mobil->ketersediaan_mobil;

            if ($status_sopir === 'tersedia' && $status_mobil === 'tersedia') {
                return response()->json([
                    'success' => false,
                    'message' => 'Status Sopir dan Mobil sudah tersedia!',
                ], 422);            
            }

            $pengiriman->sopir->ketersediaan_sopir = 'tersedia';
            $pengiriman->mobil->ketersediaan_mobil = 'tersedia';
            $pengiriman->push();

            return response()->json([
                'success' => true,
                'message' => 'Status Sopir dan Mobil berhasil diupdate',
            ], 200);
        }
    }

    public function uploadNotaSopir(Request $request, $id_pengiriman)
    {
        // Validasi request
        $request->validate([
            'bukti_nota_sopir' => 'required|image|mimes:jpeg,jpg,png',
        ]);

        // Ambil data pengiriman berdasarkan ID
        $pengiriman = Pengiriman::where('id_pengiriman', $id_pengiriman)
            ->join('sopir', 'pengiriman.id_sopir', '=', 'sopir.id_sopir')
            ->join('mobil', 'pengiriman.id_mobil', '=', 'mobil.id_mobil')
            ->first();

        if (!$pengiriman) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        }

        if ($request->hasFile('bukti_nota_sopir')) {
            $file = $request->file('bukti_nota_sopir');
            $nomor_resi = preg_replace('/[^0-9]/', '', $pengiriman->kode_pengiriman);
            $fileName = $nomor_resi . "_" . $file->getClientOriginalName();
            $file->move(public_path('img/NotaSopir'), $fileName);

            $pengiriman->update([
                'bukti_nota_sopir' => $fileName,
            ]);
        }

        $pengiriman->status_pengiriman = 'Diterima';
        $pengiriman->sopir->ketersediaan_sopir = 'tersedia';
        $pengiriman->mobil->ketersediaan_mobil = 'tersedia';
        $pengiriman->push();

        // Notif Gas Diterima
        $pesanan = Pesanan::where('id_pesanan', $pengiriman->id_pesanan)->first();
        $transaksi = Transaksi::where('id_transaksi', $pesanan->id_transaksi)->first();
        $nama_perusahaan = $transaksi->pelanggan->nama_perusahaan;
        broadcast(new GasKeluarEvent($nama_perusahaan));

        return response()->json([
            'success' => true,
            'message' => 'Data pengiriman berhasil diupdate',
            'data' => $pengiriman->bukti_nota_pengisian,
        ], 200);
    }
}