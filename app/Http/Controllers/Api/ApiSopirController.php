<?php

namespace App\Http\Controllers\Api;

use App\Events\GasKeluarEvent;
use App\Events\GasMasukEvent;
use App\Http\Controllers\Controller;
use App\Models\Gas;
use App\Models\Penarikanbop;
use App\Models\Pesanan;
use App\Models\Sopir;
use App\Models\Pengiriman;
use App\Http\Resources\PostResource;
use App\Models\Tagihan;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


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
            'kapasitas_gas_masuk' => 'required',
            'bukti_gas_masuk' => 'required|image|mimes:jpeg,jpg,png',
        ]);

        // Ambil data pengiriman berdasarkan ID
        $pengiriman = Pengiriman::find($id_pengiriman);

        if (!$pengiriman) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        }

        if ($request->hasFile('bukti_gas_masuk')) {
            $file = $request->file('bukti_gas_masuk');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('img/GasMasuk'), $fileName);

            $pengiriman->update([
                'bukti_gas_masuk' => $fileName,
            ]);
        }

        $pengiriman->waktu_pengiriman = now();
        $pengiriman->kapasitas_gas_masuk = $request->kapasitas_gas_masuk;
        $pengiriman->save();

        // $nama_sopir = $pengiriman->sopir->nama;
        // broadcast(new GasMasukEvent($nama_sopir));

        return response()->json(['message' => 'Data pengiriman berhasil diupdate']);
    }

    public function gas_keluar(Request $request, $id_pengiriman)
    {
        // Validasi request
        $request->validate([
            'sisa_gas' => 'required|string',
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

        // Perhitungan gas masuk
        $gas_keluar = $pengiriman->kapasitas_gas_masuk - $request->sisa_gas;

        // Update data pengiriman
        $pengiriman->waktu_diterima = now();
        $pengiriman->kapasitas_gas_keluar = $gas_keluar;
        $pengiriman->sisa_gas = $request->sisa_gas;

        // Perhitungan harga gas
        $id_pesanan = $pengiriman->id_pesanan;
        $harga_gas = Gas::sum('harga_gas');
        $pesanan = Pesanan::where('id_pesanan', $id_pesanan)->first();
        $pesanan->jumlah_bar = $gas_keluar;
        $pesanan->harga_pesanan = $gas_keluar * $harga_gas;

        // Perhitungan m3
        $specific_gravity = 0.75;
        $CO2 = 1;
        $N2 = 1;
        $heating_value = 1001.48361;
        $temperature = 21;
        $pressure = $gas_keluar;
        $tube_volume = 1450;
        $tube_volume2 = $tube_volume / 1000;
        $P = $pressure * 14.504;
        $P2 = (($P * (156.47 / (160.8 - 7.22 * $specific_gravity + $CO2 - 0.392 * $N2))) + 14.7) / 1000;
        $T = $temperature * 9 / 5 + 32;
        $T2 = (($T + 460) * 226.29 / (99.15 + 211.9 * $specific_gravity - ($CO2 + 1.681 * $N2))) / 500;
        $H = 0.0330378 * pow($T2, -2) - 0.0221323 * pow($T2, -3) + 0.0161353 * pow($T2, -5);
        $I = (0.265827 * pow($T2, -2) + 0.0457697 * pow($T2, -4) - 0.133185 * pow($T2, -1)) / $H;
        $B = (3 - $H * pow($I, 2)) / (9 * $H * pow($P2, 2));
        $E1 = ($T2 < 1.09) ? (1 - 0.00075 * pow($P2, 2.3) * (2 - exp(-20 * (1.09 - $T2)))) : (1 - 0.00075 * pow($P2, 2.3) * exp(-20 * ($T2 - 1.09)));
        if ($T2 < 1.09) {
            $E2 = $E1 - 1.317 * pow((1.09 - $T2), 4) * $P2 * (1.69 - pow($P2, 2));
        } else {
            $E2 = $E1 - 0.0011 * sqrt($T2 - 1.09) * pow($P2, 2) * pow((2.17 + 1.4 * sqrt($T2 - 1.09) - $P2), 2);
        }
        $F = (9 * $I - 2 * $H * pow($I, 3)) / (54 * $H * pow($P2, 3)) - ($E2 / (2 * $H * pow($P2, 2)));
        $D = pow(($F + sqrt(pow($F, 2) + pow($B, 3))), 1 / 3);
        $FPV = sqrt($B / $D - $D + $I / (3 * $P2)) / (1 + 0.00132 / pow($T2, 3.25));

        $m3 = $tube_volume2 * ($pressure + 1.01325) / 1.01325 * (273 + 27) / (273 + $temperature) * $FPV ** 2;
        $volume_std = $m3 * 35.3147 * 288.56 / 300 / 1000000;
        $heating_quantity = $volume_std * $heating_value;

        $pesanan->jumlah_m3 = $m3;
        $pesanan->save();

        // Perhitungan tagihan
        $id_transaksi = $pesanan->id_transaksi;
        $transaksi = Transaksi::where('id_transaksi', $id_transaksi)->first();
        $id_tagihan = $transaksi->id_tagihan;
        $tagihan = Tagihan::where('id_tagihan', $id_tagihan)->first();
        $tagihan->jumlah_tagihan = $tagihan->jumlah_tagihan + ($gas_keluar * $harga_gas);
        $tagihan->save();

        if ($request->hasFile('bukti_gas_keluar')) {
            $file = $request->file('bukti_gas_keluar');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('img/GasKeluar'), $fileName);

            $pengiriman->update([
                'bukti_gas_keluar' => $fileName,
            ]);
        }

        $pengiriman->status_pengiriman = 'Diterima';
        $pengiriman->sopir->ketersediaan_sopir = 'tersedia';
        $pengiriman->mobil->ketersediaan_mobil = 'tersedia';
        $pengiriman->push();

        $pesanan = Pesanan::where('id_pesanan', $pengiriman->id_pesanan)->first();
        $transaksi = Transaksi::where('id_transaksi', $pesanan->id_transaksi)->first();
        $nama_perusahaan = $transaksi->pelanggan->nama_perusahaan;
        broadcast(new GasKeluarEvent($nama_perusahaan));

        return response()->json([
            'message' => 'Data pengiriman berhasil diupdate',
            'gas_keluar' => $gas_keluar,
        ]);
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

}