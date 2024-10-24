<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Gas;
use App\Models\Mobil;
use App\Models\Sopir;
use App\Models\Pesanan;
use App\Models\Transaksi;
use App\Models\Pengiriman;
use App\Events\Chart2Event;
use Illuminate\Http\Request;
use App\Helpers\Calculations;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Pembelian';

        $transaksis = Transaksi::all();
        $pesanans = Pesanan::all();
        $gas = Gas::sum('harga_gas');
        $harga_gas = number_format($gas, 0, ',', '.');
        $data_gas = Gas::all();

        $perPage_riwayat = $request->input('perPage_riwayat', 10);
        $riwayat_transaksis = Transaksi::with('pelanggan', 'tagihan')->whereHas('tagihan', function ($query) {
            $query->whereIn('status_tagihan', ['Sudah Bayar']);
        })->orderBy('created_at', 'desc')->paginate($perPage_riwayat, ['*'], 'riwayat_transaksi')->appends(request()->query());

        return view('auth.pembelian.pembelian', [
            'transaksis' => $transaksis,
            'pesanans' => $pesanans,
            'harga_gas' => $harga_gas,
            'data_gas' => $data_gas,
            'riwayat_transaksis' => $riwayat_transaksis,
            'perPage_riwayat' => $perPage_riwayat,
        ], $data);
    }

    public function realtimeData()
    {
        $total_transaksi = Transaksi::count();
        $total_pesanan = Pesanan::count();
        $pesanan_masuk = Pesanan::whereHas('pengiriman', function ($query) {
            $query->whereIn('status_pengiriman', ['Proses']);
        })->count();
        $gas = Gas::sum('harga_gas');
        $harga_gas = number_format($gas, 0, ',', '.');
        $transaksis = Transaksi::with('pelanggan', 'tagihan')->whereHas('tagihan', function ($query) {
            $query->whereIn('status_tagihan', ['Belum Bayar'])->orWhereIn('status_tagihan', ['Diproses']);
            ;
        })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'total_transaksi' => $total_transaksi,
            'total_pesanan' => $total_pesanan,
            'pesanan_masuk' => $pesanan_masuk,
            'harga_gas' => $harga_gas,
            'transaksis' => $transaksis,
        ]);
    }

    public function detail_pesanan($id_transaksi)
    {
        $data['title'] = 'Pembelian';
        $transaksis = Transaksi::where('id_transaksi', $id_transaksi)->get();
        $pesananAwal = Pesanan::where('id_transaksi', $id_transaksi)->orderBy('tanggal_pesanan', 'asc')->first();
        $pesanans = Pesanan::where('id_transaksi', $id_transaksi)->get();
        $pesananAkhir = Pesanan::where('id_transaksi', $id_transaksi)->orderBy('tanggal_pesanan', 'desc')->first();

        $pengirimans = Pengiriman::whereIn('id_pesanan', $pesanans->pluck('id_pesanan'))->get();

        return view('auth.pembelian.more.pesanan', [
            'transaksis' => $transaksis,
            'pesananAwal' => $pesananAwal,
            'pesanans' => $pesanans,
            'pesananAkhir' => $pesananAkhir,
            'pengirimans' => $pengirimans,
        ], $data);
    }

    public function detail_tagihan($id_transaksi)
    {
        $data['title'] = 'Pembelian';

        $transaksis = Transaksi::where('id_transaksi', $id_transaksi)->get();
        $pesanans = Pesanan::where('id_transaksi', $id_transaksi)->get();

        return view('auth.pembelian.more.tagihan', [
            'transaksis' => $transaksis,
            'pesanans' => $pesanans,
        ], $data);
    }

    public function konfirmasi_pembayaran($id_transaksi)
    {
        $transaksi = Transaksi::find($id_transaksi);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan !');
        } else {
            if ($transaksi->tagihan->bukti_pembayaran == null) {
                return redirect()->back()->with('error', 'Tidak ada bukti pembayaran !');
            } else {
                $transaksi->tagihan->status_tagihan = "Sudah Bayar";
                $transaksi->tagihan->save();

                $nama_perusahaan = $transaksi->pelanggan->nama_perusahaan;
                $jumlah_tagihan = $transaksi->tagihan->jumlah_tagihan;
                $bulan = Carbon::parse($transaksi->tagihan->tanggal_pembayaran)->format('M Y');
                broadcast(new Chart2Event($nama_perusahaan, $jumlah_tagihan, $bulan));

                return redirect()->route('pembelian')->with('success', 'Pembayaran berhasil dikonfirmasi !');
            }
        }
    }

    public function print_invoice($id_transaksi)
    {
        $data['title'] = 'Print Invoice';

        $transaksis = Transaksi::where('id_transaksi', $id_transaksi)->get();
        $pesanans = Pesanan::where('id_transaksi', $id_transaksi)->get();
        $gas = Gas::sum('harga_gas');
        $harga_gas = number_format($gas, 0, ',', '.');

        return view('auth.pembelian.more.print', [
            'transaksis' => $transaksis,
            'pesanans' => $pesanans,
            'harga_gas' => $harga_gas,
        ], $data);
    }

    // Harga Gas
    // public function edit_gas($id_gas, Request $request)
    // {
    //     $request->validate([
    //         'harga_gas' => 'required',
    //     ]);

    //     $data_gas = Gas::findOrFail($id_gas);

    //     if (!$data_gas) {
    //         return redirect()->back()->with('error', 'Gas tidak ditemukan !');
    //     } else {
    //         $data_gas->fill([
    //             'harga_gas' => $request->input('harga_gas'),
    //         ]);
    //         $data_gas->save();

    //         return redirect()->back()->with('success', 'Harga gas berhasil diubah !');
    //     }
    // }

    public function detail_pengiriman($id_pesanan)
    {
        $data['title'] = 'Detail Pengiriman';
        $pengiriman = Pengiriman::where('id_pesanan', $id_pesanan)
            ->with('pesanan.transaksi.pelanggan', 'mobil', 'sopir')
            ->orderBy('created_at', 'desc')
            ->first();

        return view('auth.pembelian.more.pengiriman', [
            'pengiriman' => $pengiriman,
        ], $data);
    }

    public function realtimeDataPesanan(Request $request, $id_transaksi)
    {
        $queryPesanan = Pesanan::where('id_transaksi', $id_transaksi)
            ->with(['pengiriman.sopir', 'pengiriman.mobil', 'transaksi.pelanggan', 'transaksi.tagihan', 'transaksi.admin']);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($tanggal_akhir)->endOfDay();

            $queryPesanan = $queryPesanan->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        $pesanans = $queryPesanan->orderBy('tanggal_pesanan', 'desc')->get();
        $totalm3 = $pesanans->pluck('jumlah_m3')->sum();
        $totalharga = $pesanans->pluck('harga_pesanan')->sum();

        return response()->json([
            'pesanans' => $pesanans,
            'totalm3' => $totalm3,
            'totalharga' => $totalharga,
        ]);
    }

    public function exportExcel(Request $request, $id_transaksi)
    {
        $transaksi = Transaksi::where('id_transaksi', $id_transaksi)
            ->with('pelanggan')
            ->first();

        // Ambil data sesuai filter jika ada
        $queryPesanan = Pesanan::where('id_transaksi', $id_transaksi)
            ->with(['pengiriman.sopir', 'pengiriman.mobil', 'transaksi.pelanggan', 'transaksi.tagihan', 'transaksi.admin']);

        // Cek jika tanggal_awal dan tanggal_akhir ada dalam request
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = Carbon::parse($request->tanggal_awal)->startOfDay();
            $tanggal_akhir = Carbon::parse($request->tanggal_akhir)->endOfDay();

            $queryPesanan = $queryPesanan->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir]);
        }

        $pesanans = $queryPesanan->orderBy('tanggal_pesanan', 'desc')->get();

        // Membuat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan judul di A2
        $sheet->setCellValue('A2', 'REKAPITULASI PESANAN GAS');
        $sheet->mergeCells('A2:C2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');

        // Menambahkan Customer di A3
        $sheet->setCellValue('A3', 'Customer: ' . $transaksi->pelanggan->nama_perusahaan);
        $sheet->mergeCells('A3:C3');
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('left');

        // Menambahkan periode tanggal di A4
        $tanggalPesanan = $pesanans->pluck('tanggal_pesanan')->map(function ($date) {
            return Carbon::parse($date);
        });
        $tanggalAwal = $tanggalPesanan->min()->format('d-M-Y');
        $tanggalAkhir = $tanggalPesanan->max()->format('d-M-Y');

        $sheet->setCellValue('A4', 'Periode tanggal: ' . $tanggalAwal . ' - ' . $tanggalAkhir);
        $sheet->mergeCells('A4:C4');
        $sheet->getStyle('A4')->getFont()->setBold(true);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal('left');

        // Menetapkan judul kolom
        $sheet->setCellValue('A6', 'No')->mergeCells('A6:A7');
        $sheet->setCellValue('B6', 'Resi')->mergeCells('B6:B7');
        $sheet->setCellValue('C6', 'Hari')->mergeCells('C6:C7');
        $sheet->setCellValue('D6', 'Tanggal')->mergeCells('D6:D7');
        $sheet->setCellValue('E6', 'Pelanggan')->mergeCells('E6:E7');
        $sheet->setCellValue('F6', 'No. Pol')->mergeCells('F6:F7');

        // Set header Tekanan dengan colspan
        $sheet->setCellValue('G6', 'Tekanan')->mergeCells('G6:J6');

        // Menetapkan sub-header untuk Tekanan
        $sheet->setCellValue('G7', 'Awal');
        $sheet->setCellValue('H7', 'Akhir');
        $sheet->setCellValue('I7', 'Selisih');
        $sheet->setCellValue('J7', 'LWC');

        // Menetapkan kolom lainnya
        $sheet->setCellValue('K6', 'Volume LWC/m3')->mergeCells('K6:K7');
        $sheet->setCellValue('L6', 'Total Harga')->mergeCells('L6:L7');

        // Mengatur format header
        $sheet->getStyle('A6:L7')->getFont()->setBold(true);
        $sheet->getStyle('A6:L7')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A6:L7')->getAlignment()->setVertical('center'); // Vertical Align Center

        // Mengisi data
        $row = 8; // Mulai dari baris ketujuh setelah header
        $totalJumlahM3 = 0;
        $totalHarga = 0;

        foreach ($pesanans as $index => $pesanan) {
            $sheet->setCellValue('A' . $row, $index + 1); // No
            $sheet->setCellValue('B' . $row, $pesanan->pengiriman->kode_pengiriman);

            // Mengonversi tanggal_pesanan menjadi Carbon jika perlu
            $tanggalPesanan = Carbon::parse($pesanan->tanggal_pesanan);
            $sheet->setCellValue('C' . $row, $tanggalPesanan->format('l')); // Hari
            $sheet->setCellValue('D' . $row, $tanggalPesanan->format('d-M-Y')); // Tanggal
            $sheet->setCellValue('E' . $row, $pesanan->transaksi->pelanggan->nama_perusahaan);
            $sheet->setCellValue('F' . $row, $pesanan->pengiriman->mobil ? $pesanan->pengiriman->mobil->nopol_mobil : 'Belum Dikirim');
            $sheet->setCellValue('G' . $row, $pesanan->pengiriman->kapasitas_gas_masuk ?? 0);
            $sheet->setCellValue('H' . $row, $pesanan->pengiriman->sisa_gas ?? 0);
            $sheet->setCellValue('I' . $row, $pesanan->pengiriman->kapasitas_gas_keluar ?? 0);
            $sheet->setCellValue('J' . $row, 0); // Jika ada perhitungan selisih, ganti 0 dengan nilai yang sesuai
            $sheet->setCellValue('K' . $row, $pesanan->jumlah_m3 ?? 0);
            $sheet->setCellValue('L' . $row, $pesanan->harga_pesanan);

            // Menjumlahkan total
            $totalJumlahM3 += $pesanan->jumlah_m3 ?? 0;
            $totalHarga += $pesanan->harga_pesanan ?? 0;
            $row++;
        }

        // Menambahkan baris jumlah total
        $sheet->setCellValue('A' . $row, 'Jumlah')->mergeCells('A' . $row . ':J' . $row);
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal('center'); // Center align Jumlah
        $sheet->getStyle('A' . $row)->getFont()->setBold(true); // Center align Jumlah
        $sheet->setCellValue('K' . $row, $totalJumlahM3);
        $sheet->getStyle('K' . $row)->getFont()->setBold(true); // Center align Jumlah
        $sheet->setCellValue('L' . $row, $totalHarga);
        $sheet->getStyle('L' . $row)->getFont()->setBold(true); // Center align Jumlah

        // Mengatur lebar kolom agar sesuai dengan konten
        foreach (range('A', 'L') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Menambahkan border pada semua sel
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A6:L' . ($row))->applyFromArray($styleArray);

        // Mengatur warna latar belakang dan teks di L5
        $sheet->getStyle('A6:L7')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'e12c6c'],
            ],
            'font' => [
                'color' => ['argb' => 'FFFFFF'],
            ],
        ]);

        // Menentukan format header
        $filename = 'data_pesanan_' . $transaksi->pelanggan->nama_perusahaan . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function exportPDF(Request $request, $id_transaksi)
    {
        $transaksi = Transaksi::where('id_transaksi', $id_transaksi)
            ->with('pelanggan')
            ->first();

        // Ambil data sesuai filter jika ada
        $queryPesanan = Pesanan::where('id_transaksi', $id_transaksi)
            ->with(['pengiriman.sopir', 'pengiriman.mobil', 'transaksi.pelanggan', 'transaksi.tagihan', 'transaksi.admin']);

        // Cek jika tanggal_awal dan tanggal_akhir ada dalam request
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = Carbon::parse($request->tanggal_awal)->startOfDay();
            $tanggal_akhir = Carbon::parse($request->tanggal_akhir)->endOfDay();

            $queryPesanan = $queryPesanan->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir]);
        }

        $pesanans = $queryPesanan->orderBy('tanggal_pesanan', 'desc')->get();
        $totalJumlahM3 = $pesanans->sum('jumlah_m3');
        $totalHargaPesanan = $pesanans->sum('harga_pesanan');

        // Render view PDF
        $pdf = PDF::loadView('auth.pembelian.more.pesanan_pdf', compact('transaksi', 'pesanans', 'totalJumlahM3', 'totalHargaPesanan'));

        // Stream PDF ke browser
        return $pdf->stream('data_pesanan_' . $transaksi->pelanggan->nama_perusahaan . '.pdf');
    }

    public function hitung_m3(Request $request, $id_pengiriman)
    {
        $pengiriman = Pengiriman::where('id_pengiriman', $id_pengiriman)
            ->with(['mobil', 'sopir', 'pesanan.transaksi.tagihan'])
            ->first();

        $validatedData = $request->validate([
            'spesific_gravity' => 'required|numeric',
            'CO2' => 'required|numeric',
            'N2' => 'required|numeric',
            'heating_value' => 'required|numeric',
            'temperature' => 'required|numeric',
            'tube_volume' => 'required|numeric',
        ]);

        $pesanan = $pengiriman->pesanan;
        $pesanan->spesific_gravity = $validatedData['spesific_gravity'];
        $pesanan->CO2 = $validatedData['CO2'];
        $pesanan->N2 = $validatedData['N2'];
        $pesanan->heating_value = $validatedData['heating_value'];
        $pesanan->temperature = $validatedData['temperature'];
        $pesanan->tube_volume = $validatedData['tube_volume'];
        $pesanan->save();

        return back()->with('success', 'Data updated successfully!');
    }

    public function hitung_harga(Request $request, $id_pengiriman)
    {
        $pengiriman = Pengiriman::where('id_pengiriman', $id_pengiriman)
            ->with(['mobil', 'sopir', 'pesanan.transaksi.tagihan'])
            ->first();

        $validatedData = $request->validate([
            'gas_masuk' => 'required|numeric',
            'sisa_gas' => 'required|numeric',
            'lwc' => 'required|numeric',
        ]);

        $pengiriman->kapasitas_gas_masuk = $validatedData['gas_masuk'];
        $pengiriman->sisa_gas = $validatedData['sisa_gas'];
        $pengiriman->kapasitas_gas_keluar = $pengiriman->kapasitas_gas_masuk - $pengiriman->sisa_gas;
        $pengiriman->save();

        $pesanan = $pengiriman->pesanan;
        $pesanan->jumlah_bar = $pengiriman->kapasitas_gas_keluar;
        $pesanan->lwc = $validatedData['lwc'];

        // Hitung m3
        $specific_gravity = $pesanan->spesific_gravity;
        $CO2 = $pesanan->CO2;
        $N2 = $pesanan->N2;
        $heating_value = $pesanan->heating_value;
        $temperature = $pesanan->temperature;
        $pressure = $pesanan->pengiriman->kapasitas_gas_keluar;
        $tube_volume = $pesanan->tube_volume;
        $hitung_m3 = Calculations::calculateGasVolume([
            'specific_gravity' => $specific_gravity,
            'CO2' => $CO2,
            'N2' => $N2,
            'heating_value' => $heating_value,
            'temperature' => $temperature,
            'pressure' => $pressure,
            'tube_volume' => $tube_volume,
        ]);     
        if ($hitung_m3['status'] === 'error') {
            return back()->withErrors($hitung_m3['messages']);
        }
        $pesanan->jumlah_m3 = $hitung_m3['data']['m3'];

        // Harga Gas
        $harga_satuan = $pengiriman->pesanan->transaksi->pelanggan->harga_pelanggan;
        $pesanan->harga_pesanan = $pesanan->jumlah_m3 * $harga_satuan;
        $pesanan->save();
        
        // Masukkan tagihan
        $id_transaksi = $pengiriman->pesanan->transaksi->id_transaksi;
        $semua_pesanan = Pesanan::where('id_transaksi', $id_transaksi)->get();
        $totalHargaPesanan = $semua_pesanan->sum('harga_pesanan');
        $tagihan = $pengiriman->pesanan->transaksi->tagihan;
        $tagihan->jumlah_tagihan = $totalHargaPesanan;
        $tagihan->save();

        return back()->with('success', 'Data updated successfully!');
    }
}
