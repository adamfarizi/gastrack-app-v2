<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pesanan;
use App\Models\Keuangan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pengiriman;
use App\Models\Penarikanbop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanController extends Controller
{
    public function indexDetailPenjualan(Request $request)
    {
        $data['title'] = 'Detail Penjualan';

        $perPage_data = $request->input('perPage_data', 10);

        // Mulai query dengan relasi
        $queryData = Pesanan::with(['transaksi', 'transaksi.pelanggan', 'transaksi.tagihan', 'pengiriman'])
            ->whereHas('pengiriman', function ($query) {
                $query->where('status_pengiriman', 'Diterima');
            });

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($tanggal_akhir)->endOfDay();

            $queryData = $queryData->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
        } else {
            $tanggal_awal = Carbon::today();
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();

            $queryData = $queryData->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        // Tambahkan pengurutan dari yang lama ke baru
        $queryData = $queryData->orderBy('tanggal_pesanan', 'asc');

        // Paginasi dengan hasil yang difilter
        $data_table = $queryData
            ->paginate($perPage_data, ['*'], 'queryData')
            ->appends(request()->query());

        return view('auth.laporan.detail_penjualan', [
            'perPage_data' => $perPage_data,
            'data_table' => $data_table,
        ], $data);
    }

    public function pdfDetailPenjualan(Request $request)
    {
        // Mulai query dengan relasi
        $queryData = Pesanan::with(['transaksi', 'transaksi.pelanggan', 'transaksi.tagihan', 'pengiriman'])
            ->whereHas('pengiriman', function ($query) {
                $query->where('status_pengiriman', 'Diterima');
            });

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($tanggal_akhir)->endOfDay();

            $queryData = $queryData->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
        } else {
            $tanggal_awal = Carbon::today()->format('Y-m-d');
            $tanggal_akhir = Carbon::today()->format('Y-m-d');
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();

            $queryData = $queryData->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        // Tambahkan pengurutan dari yang lama ke baru
        $data_table = $queryData->orderBy('tanggal_pesanan', 'asc')->get();

        // Gunakan tanggal awal dan akhir dalam nama file
        $nama_file = 'detail_penjualan_' . $tanggal_awal . '_sd_' . $tanggal_akhir . '.pdf';

        // Buat PDF
        $pdf = PDF::loadView('auth.laporan.print.detail_penjualan_pdf', compact('data_table', 'tanggal_awal', 'tanggal_akhir'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream($nama_file);
    }

    public function excelDetailPenjualan(Request $request)
    {
        // Mulai query dengan relasi
        $queryData = Pesanan::with(['transaksi', 'transaksi.pelanggan', 'transaksi.tagihan', 'pengiriman'])
            ->whereHas('pengiriman', function ($query) {
                $query->where('status_pengiriman', 'Diterima');
            });

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($tanggal_akhir)->endOfDay();

            $queryData = $queryData->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
        } else {
            $tanggal_awal = Carbon::today()->format('Y-m-d');
            $tanggal_akhir = Carbon::today()->format('Y-m-d');
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();

            $queryData = $queryData->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        // Tambahkan pengurutan dari yang lama ke baru
        $data_table = $queryData->orderBy('tanggal_pesanan', 'asc')->get();

        // Membuat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan judul di A2
        $sheet->setCellValue('A2', 'DETAIL PENJUALAN')->mergeCells('A2:C2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');

        // Menambahkan periode tanggal di A3
        $tanggalPesanan = $data_table->pluck('tanggal_pesanan')->map(function ($date) {
            return Carbon::parse($date);
        });
        $tanggalAwal = $tanggalPesanan->min()->format('d-M-Y');
        $tanggalAkhir = $tanggalPesanan->max()->format('d-M-Y');

        $sheet->setCellValue('A3', 'Tanggal : ' . $tanggalAwal . ' sd ' . $tanggalAkhir)->mergeCells('A3:C3');
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('left');

        // Menetapkan judul kolom
        $sheet->setCellValue('A5', 'Resi');
        $sheet->setCellValue('B5', 'Tanggal Pesanan');
        $sheet->setCellValue('C5', 'Pelanggan');
        $sheet->setCellValue('D5', 'Tujuan');
        $sheet->setCellValue('E5', 'Jumlah Pesanan Bar');
        $sheet->setCellValue('F5', 'Jumlah Pesanan M3');
        $sheet->setCellValue('G5', 'Harga');
        $sheet->setCellValue('H5', 'Waktu Payment');
        $sheet->setCellValue('I5', 'Payment Methode');

        // Mengatur format header
        $sheet->getStyle('A5:I5')->getFont()->setBold(true);
        $sheet->getStyle('A5:I5')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A5:I5')->getAlignment()->setVertical('center'); // Vertical Align Center

        // Menetapkan lebar kolom D dan membungkus teks
        $sheet->getColumnDimension('D')->setWidth(20); // Set lebar kolom D
        $sheet->getStyle('D')->getAlignment()->setWrapText(true); // Mengaktifkan wrap text

        // Mengisi data
        $row = 6;

        foreach ($data_table as $index => $pesanan) {
            $sheet->setCellValue('A' . $row, $pesanan->transaksi->resi_transaksi);
            $tanggalPesanan = Carbon::parse($pesanan->tanggal_pesanan);
            $sheet->setCellValue('B' . $row, $tanggalPesanan->format('d-M-Y H:i'));
            $sheet->setCellValue('C' . $row, $pesanan->transaksi->pelanggan->nama_perusahaan);
            $sheet->setCellValue('D' . $row, $pesanan->transaksi->pelanggan->alamat);
            $sheet->setCellValue('E' . $row, $pesanan->jumlah_bar ?? 0);
            $sheet->setCellValue('F' . $row, $pesanan->jumlah_m3 ?? 0);
            $sheet->setCellValue('G' . $row, $pesanan->harga_pesanan);
            $sheet->setCellValue(
                'H' . $row,
                ($pesanan->transaksi->tagihan->status_tagihan === 'Sudah Bayar' ||
                    $pesanan->transaksi->tagihan->status_tagihan === 'Diproses')
                ? date('d/M/Y', strtotime($pesanan->transaksi->tagihan->tanggal_pembayaran)) . ' ' . date('H:i', strtotime($pesanan->transaksi->tagihan->tanggal_pembayaran))
                : 'Belum Bayar'
            );
            $sheet->setCellValue(
                'I' . $row,
                ($pesanan->transaksi->tagihan->status_tagihan === 'Sudah Bayar' ||
                    $pesanan->transaksi->tagihan->status_tagihan === 'Diproses')
                ? 'Tunai' : 'Belum Bayar'
            );

            $row++;
        }

        // Mengatur lebar kolom agar sesuai dengan konten, kecuali kolom D
        foreach (range('A', 'C') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        foreach (range('E', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Menambahkan border pada semua sel
        $lastRow = $row - 1;
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A5:I' . ($lastRow))->applyFromArray($styleArray);

        // Mengatur alignment teks untuk seluruh kolom agar vertikal tengah
        $sheet->getStyle('A5:I' . $lastRow)->getAlignment()->setVertical('center');

        // Mengatur warna latar belakang dan teks di L5
        $sheet->getStyle('A5:I5')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'e12c6c'],
            ],
            'font' => [
                'color' => ['argb' => 'FFFFFF'],
            ],
        ]);

        // Menentukan format header
        $filename = 'detail_penjualan_' . $tanggalAwal . '_sd_' . $tanggalAkhir . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function indexOmzetPenjualan(Request $request)
    {
        $data['title'] = 'Omzet Penjualan';

        $perPage_data = $request->input('perPage_data', 10);

        // Mulai query dengan relasi
        $queryData = Pesanan::with(['transaksi', 'transaksi.pelanggan', 'transaksi.tagihan', 'pengiriman'])
            ->whereHas('pengiriman', function ($query) {
                $query->where('status_pengiriman', 'Diterima');
            });

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($tanggal_akhir)->endOfDay();

            $queryData = $queryData->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
        } else {
            $tanggal_awal = Carbon::today();
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();

            $queryData = $queryData->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        // Tambahkan pengurutan dari yang lama ke baru
        $queryData = $queryData->orderBy('tanggal_pesanan', 'asc');

        // Paginasi dengan hasil yang difilter
        $data_table = $queryData
            ->paginate($perPage_data, ['*'], 'queryData')
            ->appends(request()->query());

        $totalHargaPesanan = $queryData->sum('harga_pesanan');

        return view('auth.laporan.omzet_penjualan', [
            'perPage_data' => $perPage_data,
            'data_table' => $data_table,
            'totalHargaPesanan' => $totalHargaPesanan,
        ], $data);
    }

    public function pdfOmzetPenjualan(Request $request)
    {
        // Mulai query dengan relasi
        $queryData = Pesanan::with(['transaksi', 'transaksi.pelanggan', 'transaksi.tagihan', 'pengiriman'])
            ->whereHas('pengiriman', function ($query) {
                $query->where('status_pengiriman', 'Diterima');
            });

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($tanggal_akhir)->endOfDay();

            $queryData = $queryData->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
        } else {
            $tanggal_awal = Carbon::today()->format('Y-m-d');
            $tanggal_akhir = Carbon::today()->format('Y-m-d');
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();

            $queryData = $queryData->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        // Tambahkan pengurutan dari yang lama ke baru
        $data_table = $queryData->orderBy('tanggal_pesanan', 'asc')->get();
        $totalHargaPesanan = $queryData->sum('harga_pesanan');

        // Gunakan tanggal awal dan akhir dalam nama file
        $nama_file = 'omzet_penjualan_' . $tanggal_awal . '_sd_' . $tanggal_akhir . '.pdf';

        // Buat PDF
        $pdf = PDF::loadView('auth.laporan.print.omzet_penjualan_pdf', compact('data_table', 'totalHargaPesanan', 'tanggal_awal', 'tanggal_akhir'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream($nama_file);
    }

    public function excelOmzetPenjualan(Request $request)
    {
        // Mulai query dengan relasi
        $queryData = Pesanan::with(['transaksi', 'transaksi.pelanggan', 'transaksi.tagihan', 'pengiriman'])
            ->whereHas('pengiriman', function ($query) {
                $query->where('status_pengiriman', 'Diterima');
            });

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($tanggal_akhir)->endOfDay();

            $queryData = $queryData->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
        } else {
            $tanggal_awal = Carbon::today();
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();

            $queryData = $queryData->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        // Tambahkan pengurutan dari yang lama ke baru
        $data_table = $queryData->orderBy('tanggal_pesanan', 'asc')->get();
        $totalHargaPesanan = $queryData->sum('harga_pesanan');

        // Membuat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan judul di A2
        $sheet->setCellValue('A2', 'OMZET PENJUALAN')->mergeCells('A2:C2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');

        // Menambahkan periode tanggal di A3
        $tanggalPesanan = $data_table->pluck('tanggal_pesanan')->map(function ($date) {
            return Carbon::parse($date);
        });
        $tanggalAwal = $tanggalPesanan->min()->format('d-M-Y');
        $tanggalAkhir = $tanggalPesanan->max()->format('d-M-Y');

        $sheet->setCellValue('A3', 'Tanggal : ' . $tanggalAwal . ' sd ' . $tanggalAkhir)->mergeCells('A3:C3');
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('left');

        // Menetapkan judul kolom
        $sheet->setCellValue('A5', 'Invoice');
        $sheet->setCellValue('B5', 'Pelanggan');
        $sheet->setCellValue('C5', 'Tujuan');
        $sheet->setCellValue('D5', 'Jumlah Pesanan Bar');
        $sheet->setCellValue('E5', 'Jumlah Pesanan M3');
        $sheet->setCellValue('F5', 'Omzet');

        // Mengatur format header
        $sheet->getStyle('A5:F5')->getFont()->setBold(true);
        $sheet->getStyle('A5:F5')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A5:F5')->getAlignment()->setVertical('center'); // Vertical Align Center

        // Menetapkan lebar kolom D dan membungkus teks
        $sheet->getColumnDimension('C')->setWidth(50); // Set lebar kolom D
        $sheet->getStyle('C')->getAlignment()->setWrapText(true); // Mengaktifkan wrap text

        // Mengisi data
        $row = 6;

        foreach ($data_table as $index => $pesanan) {
            $sheet->setCellValue('A' . $row, $pesanan->transaksi->resi_transaksi);
            $sheet->setCellValue('B' . $row, $pesanan->transaksi->pelanggan->nama_perusahaan);
            $sheet->setCellValue('C' . $row, $pesanan->transaksi->pelanggan->alamat);
            $sheet->setCellValue('D' . $row, $pesanan->jumlah_bar ?? 0);
            $sheet->setCellValue('E' . $row, $pesanan->jumlah_m3 ?? 0);
            $sheet->setCellValue('F' . $row, $pesanan->harga_pesanan);

            $row++;
        }

        // Menambahkan baris jumlah total
        $sheet->setCellValue('A' . $row, 'Total Omzet')->mergeCells('A' . $row . ':E' . $row);
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal('center'); // Center align Jumlah
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->setCellValue('F' . $row, $totalHargaPesanan);
        $sheet->getStyle('F' . $row)->getFont()->setBold(true);

        // Mengatur lebar kolom agar sesuai dengan konten
        foreach (range('A', 'B') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        foreach (range('D', 'F') as $column) {
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
        $sheet->getStyle('A5:F' . ($row))->applyFromArray($styleArray);

        // Mengatur alignment teks untuk seluruh kolom agar vertikal tengah
        $sheet->getStyle('A5:F' . $row)->getAlignment()->setVertical('center');

        // Mengatur warna latar belakang dan teks di L5
        $sheet->getStyle('A5:F5')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'e12c6c'],
            ],
            'font' => [
                'color' => ['argb' => 'FFFFFF'],
            ],
        ]);

        // Menentukan format header
        $filename = 'omzet_penjualan_' . $tanggalAwal . '_sd_' . $tanggalAkhir . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function indexLaporanBOP(Request $request)
    {
        $data['title'] = 'Laporan BOP';

        $perPage_data = $request->input('perPage_data', 10);

        // Mulai query dengan relasi
        $queryData = Pengiriman::with(['pesanan', 'pesanan.transaksi.pelanggan', 'sopir', 'sopir.penarikanbop'])
            ->whereNotNull('id_sopir');

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($tanggal_akhir)->endOfDay();

            $queryData = $queryData->whereBetween('waktu_pengiriman', [$tanggal_awal, $tanggal_akhir_full_day]);
        } else {
            $tanggal_awal = Carbon::today();
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();

            $queryData = $queryData->whereBetween('waktu_pengiriman', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        // Tambahkan pengurutan dari yang lama ke baru
        $queryData = $queryData->orderBy('waktu_pengiriman', 'asc');

        // Paginasi dengan hasil yang difilter
        $data_table = $queryData
            ->paginate($perPage_data, ['*'], 'queryData')
            ->appends(request()->query());

        return view('auth.laporan.laporan_bop', [
            'perPage_data' => $perPage_data,
            'data_table' => $data_table,
        ], $data);
    }

    public function pdfLaporanBOP(Request $request)
    {
        // Mulai query dengan relasi
        $queryData = Pengiriman::with(['pesanan', 'pesanan.transaksi.pelanggan', 'sopir', 'sopir.penarikanbop'])
            ->whereNotNull('id_sopir');

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($tanggal_akhir)->endOfDay();

            $queryData = $queryData->whereBetween('waktu_pengiriman', [$tanggal_awal, $tanggal_akhir_full_day]);
        } else {
            $tanggal_awal = Carbon::today()->format('Y-m-d');
            $tanggal_akhir = Carbon::today()->format('Y-m-d');
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();

            $queryData = $queryData->whereBetween('waktu_pengiriman', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        // Tambahkan pengurutan dari yang lama ke baru
        $data_table = $queryData->orderBy('waktu_pengiriman', 'asc')->get();

        // Gunakan tanggal awal dan akhir dalam nama file
        $nama_file = 'laporan_bop_' . $tanggal_awal . '_sd_' . $tanggal_akhir . '.pdf';

        // Buat PDF
        $pdf = PDF::loadView('auth.laporan.print.laporan_bop_pdf', compact('data_table', 'tanggal_awal', 'tanggal_akhir'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream($nama_file);
    }

    public function excelLaporanBOP(Request $request)
    {
        // Mulai query dengan relasi
        $queryData = Pengiriman::with(['pesanan', 'pesanan.transaksi.pelanggan', 'sopir', 'sopir.penarikanbop'])
            ->whereNotNull('id_sopir');

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($tanggal_akhir)->endOfDay();

            $queryData = $queryData->whereBetween('waktu_pengiriman', [$tanggal_awal, $tanggal_akhir_full_day]);
        } else {
            $tanggal_awal = Carbon::today();
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();

            $queryData = $queryData->whereBetween('waktu_pengiriman', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        // Tambahkan pengurutan dari yang lama ke baru
        $data_table = $queryData->orderBy('waktu_pengiriman', 'asc')->get();

        // Membuat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan judul di A2
        $sheet->setCellValue('A2', 'LAPORAN BOP')->mergeCells('A2:C2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');

        // Menambahkan periode tanggal di A3
        $tanggalPesanan = $data_table->pluck('tanggal_pesanan')->map(function ($date) {
            return Carbon::parse($date);
        });
        $tanggalAwal = $tanggalPesanan->min()->format('d-M-Y');
        $tanggalAkhir = $tanggalPesanan->max()->format('d-M-Y');

        $sheet->setCellValue('A3', 'Tanggal : ' . $tanggalAwal . ' sd ' . $tanggalAkhir)->mergeCells('A3:C3');
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('left');

        // Menetapkan judul kolom
        $sheet->setCellValue('A5', 'Resi Pengiriman');
        $sheet->setCellValue('B5', 'Tanggal Pengiriman');
        $sheet->setCellValue('C5', 'Pelanggan');
        $sheet->setCellValue('D5', 'Tujuan');
        $sheet->setCellValue('E5', 'Sopir');
        $sheet->setCellValue('F5', 'BOP');

        // Mengatur format header
        $sheet->getStyle('A5:F5')->getFont()->setBold(true);
        $sheet->getStyle('A5:F5')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A5:F5')->getAlignment()->setVertical('center'); // Vertical Align Center

        // Menetapkan lebar kolom D dan membungkus teks
        $sheet->getColumnDimension('D')->setWidth(50); // Set lebar kolom D
        $sheet->getStyle('D')->getAlignment()->setWrapText(true); // Mengaktifkan wrap text

        // Mengisi data
        $row = 6;

        foreach ($data_table as $index => $pengiriman) {
            $sheet->setCellValue('A' . $row, $pengiriman->kode_pengiriman);
            $sheet->setCellValue(
                'B' . $row,
                ($pengiriman->waktu_pengiriman)
                ? Carbon::parse($pengiriman->waktu_pengiriman)->format('d-M-Y H:i')
                : 'Belum Dikirim'
            );
            $sheet->setCellValue('C' . $row, $pengiriman->pesanan->transaksi->pelanggan->nama_perusahaan);
            $sheet->setCellValue('D' . $row, $pengiriman->pesanan->transaksi->pelanggan->alamat);
            $sheet->setCellValue(
                'E' . $row,
                (!$pengiriman->sopir)
                ? 'Belum Dikirim'
                : $pengiriman->sopir->nama
            );
            $sheet->setCellValue('F' . $row, $pengiriman->pesanan->transaksi->pelanggan->bop_pelanggan);

            $row++;
        }

        // Mengatur lebar kolom agar sesuai dengan konten, kecuali kolom D
        foreach (range('A', 'C') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        foreach (range('E', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Menambahkan border pada semua sel
        $lastRow = $row - 1;
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A5:F' . ($lastRow))->applyFromArray($styleArray);

        // Mengatur alignment teks untuk seluruh kolom agar vertikal tengah
        $sheet->getStyle('A5:F' . $lastRow)->getAlignment()->setVertical('center');

        // Mengatur warna latar belakang dan teks di L5
        $sheet->getStyle('A5:F5')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'e12c6c'],
            ],
            'font' => [
                'color' => ['argb' => 'FFFFFF'],
            ],
        ]);

        // Menentukan format header
        $filename = 'laporan_bop_' . $tanggalAwal . '_sd_' . $tanggalAkhir . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function indexModalTambahan(Request $request)
    {
        $data['title'] = 'Modal Tambahan';

        $perPage_data = $request->input('perPage_data', 10);

        // Mulai query dengan relasi, sekarang mengambil data dari tabel Keuangan
        $queryData = Keuangan::where('jenis', 'debet')->with(['admin']);

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($tanggal_akhir)->endOfDay();

            // Filter berdasarkan tanggal
            $queryData = $queryData->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
        } else {
            $tanggal_awal = Carbon::today();
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();

            $queryData = $queryData->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        // Tambahkan pengurutan dari yang lama ke baru
        $queryData = $queryData->orderBy('tanggal', 'asc');

        // Paginasi dengan hasil yang difilter
        $data_table = $queryData
            ->paginate($perPage_data, ['*'], 'queryData')  // Sesuaikan dengan nama parameter untuk paginasi
            ->appends(request()->query());

        // Kirim data ke view
        return view('auth.laporan.modal_tambahan', [
            'perPage_data' => $perPage_data,
            'data_table' => $data_table,
        ], $data);
    }

    public function pdfModalTambahan(Request $request)
    {
        // Mulai query dengan relasi
        $queryData = Keuangan::where('jenis', 'debet')->with(['admin']);

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($tanggal_akhir)->endOfDay();

            $queryData = $queryData->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
        } else {
            $tanggal_awal = Carbon::today()->format('Y-m-d');
            $tanggal_akhir = Carbon::today()->format('Y-m-d');
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();

            $queryData = $queryData->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        // Tambahkan pengurutan dari yang lama ke baru
        $data_table = $queryData->orderBy('tanggal', 'asc')->get();

        // Gunakan tanggal awal dan akhir dalam nama file
        $nama_file = 'modal_tambahan_' . $tanggal_awal . '_sd_' . $tanggal_akhir . '.pdf';

        // Buat PDF
        $pdf = PDF::loadView('auth.laporan.print.modal_tambahan_pdf', compact('data_table', 'tanggal_awal', 'tanggal_akhir'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream($nama_file);
    }

    public function excelModalTambahan(Request $request)
    {
        // Mulai query dengan relasi, sekarang mengambil data dari tabel Keuangan
        $queryData = Keuangan::where('jenis', 'debet')->with(['admin']);

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($tanggal_akhir)->endOfDay();

            // Filter berdasarkan tanggal
            $queryData = $queryData->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
        } else {
            $tanggal_awal = Carbon::today();
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();

            $queryData = $queryData->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        // Tambahkan pengurutan dari yang lama ke baru
        $data_table = $queryData->orderBy('tanggal', 'asc')->get();

        // Membuat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan judul di A2
        $sheet->setCellValue('A2', 'MODAL TAMBAHAN')->mergeCells('A2:C2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');

        // Menambahkan periode tanggal di A3
        $tanggalPesanan = $data_table->pluck('tanggal_pesanan')->map(function ($date) {
            return Carbon::parse($date);
        });
        $tanggalAwal = $tanggalPesanan->min()->format('d-M-Y');
        $tanggalAkhir = $tanggalPesanan->max()->format('d-M-Y');

        $sheet->setCellValue('A3', 'Tanggal : ' . $tanggalAwal . ' sd ' . $tanggalAkhir)->mergeCells('A3:C3');
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('left');

        // Menetapkan judul kolom
        $sheet->setCellValue('A5', 'Jenis Akun Bayar');
        $sheet->setCellValue('B5', 'Tanggal');
        $sheet->setCellValue('C5', 'Deskripsi');
        $sheet->setCellValue('D5', 'Jumlah Modal');

        // Mengatur format header
        $sheet->getStyle('A5:D5')->getFont()->setBold(true);
        $sheet->getStyle('A5:D5')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A5:D5')->getAlignment()->setVertical('center'); // Vertical Align Center

        // Menetapkan lebar kolom D dan membungkus teks
        $sheet->getColumnDimension('C')->setWidth(50); // Set lebar kolom D
        $sheet->getStyle('C')->getAlignment()->setWrapText(true); // Mengaktifkan wrap text

        // Mengisi data
        $row = 6;

        foreach ($data_table as $index => $keuangan) {
            $sheet->setCellValue('A' . $row, 'Debet');
            $tanggalKeuangan = Carbon::parse($keuangan->tanggal);
            $sheet->setCellValue('B' . $row, $tanggalKeuangan->format('d-M-Y H:i'));
            $sheet->setCellValue('C' . $row, $keuangan->deskripsi);
            $sheet->setCellValue('D' . $row, $keuangan->jumlah);

            $row++;
        }

        // Mengatur lebar kolom agar sesuai dengan konten, kecuali kolom D
        foreach (range('A', 'B') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        foreach (range('D', 'D') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Menambahkan border pada semua sel
        $lastRow = $row - 1;
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A5:D' . ($lastRow))->applyFromArray($styleArray);

        // Mengatur alignment teks untuk seluruh kolom agar vertikal tengah
        $sheet->getStyle('A5:D' . $lastRow)->getAlignment()->setVertical('center');

        // Mengatur warna latar belakang dan teks di L5
        $sheet->getStyle('A5:D5')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'e12c6c'],
            ],
            'font' => [
                'color' => ['argb' => 'FFFFFF'],
            ],
        ]);

        // Menentukan format header
        $filename = 'modal_tambahan_' . $tanggalAwal . '_sd_' . $tanggalAkhir . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function createModalTambahan(Request $request)
    {
        // Validasi data yang dikirimkan
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'required|string|max:255',
        ]);

        // Ambil data dari form
        $data = $request->all();

        // Simpan data ke tabel keuangan
        $keuangan = new Keuangan();
        $keuangan->jenis = 'debet'; // Atur jenis default sesuai kebutuhan Anda, misalnya debet
        $keuangan->tanggal = Carbon::parse($data['tanggal']);
        $keuangan->deskripsi = $data['deskripsi'];
        $keuangan->jumlah = $data['jumlah'];
        $keuangan->id_admin = Auth::user()->id_admin; // Jika menggunakan autentikasi dan ingin mengaitkan dengan admin yang login
        $keuangan->save();

        // Redirect ke halaman tertentu setelah data disimpan
        return redirect('/laporan/modal_tambahan')->with('success', 'Data modal tambahan berhasil ditambahkan.');
    }

    public function indexKasKeluar(Request $request)
    {
        $data['title'] = 'Modal Tambahan';

        $perPage_data = $request->input('perPage_data', 10);

        // Mulai query dengan relasi, sekarang mengambil data dari tabel Keuangan
        $queryData = Keuangan::where('jenis', 'kredit')->with(['admin']);

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($tanggal_akhir)->endOfDay();

            // Filter berdasarkan tanggal
            $queryData = $queryData->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
        } else {
            $tanggal_awal = Carbon::today();
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();

            $queryData = $queryData->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        // Tambahkan pengurutan dari yang lama ke baru
        $queryData = $queryData->orderBy('tanggal', 'asc');

        // Paginasi dengan hasil yang difilter
        $data_table = $queryData
            ->paginate($perPage_data, ['*'], 'queryData')  // Sesuaikan dengan nama parameter untuk paginasi
            ->appends(request()->query());

        // Kirim data ke view
        return view('auth.laporan.kas_keluar', [
            'perPage_data' => $perPage_data,
            'data_table' => $data_table,
        ], $data);
    }

    public function pdfKasKeluar(Request $request)
    {
        // Mulai query dengan relasi
        $queryData = Keuangan::where('jenis', 'kredit')->with(['admin']);

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($tanggal_akhir)->endOfDay();

            $queryData = $queryData->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
        } else {
            $tanggal_awal = Carbon::today()->format('Y-m-d');
            $tanggal_akhir = Carbon::today()->format('Y-m-d');
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();

            $queryData = $queryData->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        // Tambahkan pengurutan dari yang lama ke baru
        $data_table = $queryData->orderBy('tanggal', 'asc')->get();

        // Gunakan tanggal awal dan akhir dalam nama file
        $nama_file = 'kas_keluar_' . $tanggal_awal . '_sd_' . $tanggal_akhir . '.pdf';

        // Buat PDF
        $pdf = PDF::loadView('auth.laporan.print.kas_keluar_pdf', compact('data_table', 'tanggal_awal', 'tanggal_akhir'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream($nama_file);
    }

    public function excelKasKeluar(Request $request)
    {
        // Mulai query dengan relasi, sekarang mengambil data dari tabel Keuangan
        $queryData = Keuangan::where('jenis', 'kredit')->with(['admin']);

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($tanggal_akhir)->endOfDay();

            // Filter berdasarkan tanggal
            $queryData = $queryData->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
        } else {
            $tanggal_awal = Carbon::today();
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();

            $queryData = $queryData->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        // Tambahkan pengurutan dari yang lama ke baru
        $data_table = $queryData->orderBy('tanggal', 'asc')->get();

        // Membuat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan judul di A2
        $sheet->setCellValue('A2', 'KAS KELUAR')->mergeCells('A2:C2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');

        // Menambahkan periode tanggal di A3
        $tanggalPesanan = $data_table->pluck('tanggal_pesanan')->map(function ($date) {
            return Carbon::parse($date);
        });
        $tanggalAwal = $tanggalPesanan->min()->format('d-M-Y');
        $tanggalAkhir = $tanggalPesanan->max()->format('d-M-Y');

        $sheet->setCellValue('A3', 'Tanggal : ' . $tanggalAwal . ' sd ' . $tanggalAkhir)->mergeCells('A3:C3');
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('left');

        // Menetapkan judul kolom
        $sheet->setCellValue('A5', 'Jenis Akun Bayar');
        $sheet->setCellValue('B5', 'Tanggal');
        $sheet->setCellValue('C5', 'Deskripsi');
        $sheet->setCellValue('D5', 'Jumlah Modal');

        // Mengatur format header
        $sheet->getStyle('A5:D5')->getFont()->setBold(true);
        $sheet->getStyle('A5:D5')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A5:D5')->getAlignment()->setVertical('center'); // Vertical Align Center

        // Menetapkan lebar kolom D dan membungkus teks
        $sheet->getColumnDimension('C')->setWidth(50); // Set lebar kolom D
        $sheet->getStyle('C')->getAlignment()->setWrapText(true); // Mengaktifkan wrap text

        // Mengisi data
        $row = 6;

        foreach ($data_table as $index => $keuangan) {
            $sheet->setCellValue('A' . $row, 'Kredit');
            $tanggalKeuangan = Carbon::parse($keuangan->tanggal);
            $sheet->setCellValue('B' . $row, $tanggalKeuangan->format('d-M-Y H:i'));
            $sheet->setCellValue('C' . $row, $keuangan->deskripsi);
            $sheet->setCellValue('D' . $row, $keuangan->jumlah);

            $row++;
        }

        // Mengatur lebar kolom agar sesuai dengan konten, kecuali kolom D
        foreach (range('A', 'B') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        foreach (range('D', 'D') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Menambahkan border pada semua sel
        $lastRow = $row - 1;
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A5:D' . ($lastRow))->applyFromArray($styleArray);

        // Mengatur alignment teks untuk seluruh kolom agar vertikal tengah
        $sheet->getStyle('A5:D' . $lastRow)->getAlignment()->setVertical('center');

        // Mengatur warna latar belakang dan teks di L5
        $sheet->getStyle('A5:D5')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'e12c6c'],
            ],
            'font' => [
                'color' => ['argb' => 'FFFFFF'],
            ],
        ]);

        // Menentukan format header
        $filename = 'kas_keluar_' . $tanggalAwal . '_sd_' . $tanggalAkhir . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function createKasKeluar(Request $request)
    {
        // Validasi data yang dikirimkan
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'required|string|max:255',
        ]);

        // Ambil data dari form
        $data = $request->all();

        // Simpan data ke tabel keuangan
        $keuangan = new Keuangan();
        $keuangan->jenis = 'kredit'; // Atur jenis default sesuai kebutuhan Anda, misalnya debet
        $keuangan->tanggal = Carbon::parse($data['tanggal']);
        $keuangan->deskripsi = $data['deskripsi'];
        $keuangan->jumlah = $data['jumlah'];
        $keuangan->id_admin = Auth::user()->id_admin; // Jika menggunakan autentikasi dan ingin mengaitkan dengan admin yang login
        $keuangan->save();

        // Redirect ke halaman tertentu setelah data disimpan
        return redirect('/laporan/kas_keluar')->with('success', 'Data kas keluar berhasil ditambahkan.');
    }

    public function editKeuangan(Request $request, $id_keuangan)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'required|string|max:255',
        ]);

        // Cari data keuangan berdasarkan id
        $keuangan = Keuangan::findOrFail($id_keuangan);

        // Update data keuangan
        $keuangan->tanggal = Carbon::parse($request->tanggal);
        $keuangan->jumlah = $request->jumlah;
        $keuangan->deskripsi = $request->deskripsi;
        $keuangan->save();

        // Redirect ke halaman index dengan pesan sukses
        if ($keuangan->jenis == 'debet') {
            return redirect('/laporan/modal_tambahan')->with('success', 'Data modal tambahan berhasil diperbarui.');
        } else {
            return redirect('/laporan/kas_keluar')->with('success', 'Data kas keluar berhasil diperbarui.');
        }
    }

    public function deleteKeuangan($id_keuangan)
    {
        // Cari data keuangan berdasarkan id dan hapus
        $keuangan = Keuangan::findOrFail($id_keuangan);
        $keuangan->delete();

        // Redirect ke halaman index dengan pesan sukses
        if ($keuangan->jenis == 'debet') {
            return redirect('/laporan/modal_tambahan')->with('success', 'Data modal tambahan berhasil dihapus.');
        } else {
            return redirect('/laporan/kas_keluar')->with('success', 'Data kas keluar berhasil dihapus.');
        }
    }

    public function indexLabaRugi(Request $request)
    {
        $data['title'] = 'Laporan Laba Rugi';

        // Mulai query untuk transaksi pendapatan penjualan
        $queryPenjualan = Pesanan::query();

        // Mulai query untuk modal tambahan
        $queryModalTambahan = Keuangan::where('jenis', 'debet');

        // Mulai query untuk kas keluar
        $queryKasKeluar = Keuangan::where('jenis', 'kredit');

        // Mulai query untuk BOP
        $queryBOP = Pesanan::query();

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal')) {
            $tanggal = $request->tanggal;

            // Filter berdasarkan tanggal tertentu (menggunakan whereDate untuk mencocokkan tanggal secara tepat)
            $queryPenjualan = $queryPenjualan->whereDate('tanggal_pesanan', '=', $tanggal);
            $queryModalTambahan = $queryModalTambahan->whereDate('tanggal', '=', $tanggal);
            $queryKasKeluar = $queryKasKeluar->whereDate('tanggal', '=', $tanggal);
            $queryBOP = $queryBOP->whereDate('tanggal_pesanan', '=', $tanggal);
        } else {
            // Jika tidak ada tanggal yang dipilih, default ke hari ini
            $tanggal = Carbon::today()->format('Y-m-d'); // Format tanggal hari ini (YYYY-MM-DD)

            // Filter berdasarkan tanggal hari ini
            $queryPenjualan = $queryPenjualan->whereDate('tanggal_pesanan', '=', $tanggal);
            $queryModalTambahan = $queryModalTambahan->whereDate('tanggal', '=', $tanggal);
            $queryKasKeluar = $queryKasKeluar->whereDate('tanggal', '=', $tanggal);
            $queryBOP = $queryBOP->whereDate('tanggal_pesanan', '=', $tanggal);
        }

        // Dapatkan semua data dari setiap query
        $dataPenjualan = $queryPenjualan->get();
        $dataModalTambahan = $queryModalTambahan->get();
        $dataKasKeluar = $queryKasKeluar->get();
        $dataBOP = $queryBOP->get();

        // Hitung total dari masing-masing komponen
        $totalPenjualan = $dataPenjualan->sum('harga_pesanan');
        $totalModalTambahan = $dataModalTambahan->sum('jumlah');
        $totalKasKeluar = $dataKasKeluar->sum('jumlah');
        $totalBOP = $dataBOP->sum('bop_pesanan');

        // Hitung laba rugi
        $labaRugi = $totalPenjualan + $totalModalTambahan - $totalKasKeluar - $totalBOP;

        return view('auth.laporan.laba_rugi', [
            'dataPenjualan' => $dataPenjualan,
            'dataModalTambahan' => $dataModalTambahan,
            'dataKasKeluar' => $dataKasKeluar,
            'dataBOP' => $dataBOP,
            'totalPenjualan' => $totalPenjualan,
            'totalModalTambahan' => $totalModalTambahan,
            'totalKasKeluar' => $totalKasKeluar,
            'totalBOP' => $totalBOP,
            'labaRugi' => $labaRugi,
        ], $data);
    }

    public function pdfLabaRugi(Request $request)
    {
        // Mulai query untuk transaksi pendapatan penjualan
        $queryPenjualan = Pesanan::query();

        // Mulai query untuk modal tambahan
        $queryModalTambahan = Keuangan::where('jenis', 'debet');

        // Mulai query untuk kas keluar
        $queryKasKeluar = Keuangan::where('jenis', 'kredit');

        // Mulai query untuk BOP
        $queryBOP = Pesanan::query();

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal')) {
            $tanggal = $request->tanggal;

            // Filter berdasarkan tanggal tertentu (menggunakan whereDate untuk mencocokkan tanggal secara tepat)
            $queryPenjualan = $queryPenjualan->whereDate('tanggal_pesanan', '=', $tanggal);
            $queryModalTambahan = $queryModalTambahan->whereDate('tanggal', '=', $tanggal);
            $queryKasKeluar = $queryKasKeluar->whereDate('tanggal', '=', $tanggal);
            $queryBOP = $queryBOP->whereDate('tanggal_pesanan', '=', $tanggal);
        } else {
            // Jika tidak ada tanggal yang dipilih, default ke hari ini
            $tanggal = Carbon::today()->format('Y-m-d'); // Format tanggal hari ini (YYYY-MM-DD)

            // Filter berdasarkan tanggal hari ini
            $queryPenjualan = $queryPenjualan->whereDate('tanggal_pesanan', '=', $tanggal);
            $queryModalTambahan = $queryModalTambahan->whereDate('tanggal', '=', $tanggal);
            $queryKasKeluar = $queryKasKeluar->whereDate('tanggal', '=', $tanggal);
            $queryBOP = $queryBOP->whereDate('tanggal_pesanan', '=', $tanggal);
        }

        // Dapatkan semua data dari setiap query
        $dataPenjualan = $queryPenjualan->get();
        $dataModalTambahan = $queryModalTambahan->get();
        $dataKasKeluar = $queryKasKeluar->get();
        $dataBOP = $queryBOP->get();

        // Hitung total dari masing-masing komponen
        $totalPenjualan = $dataPenjualan->sum('harga_pesanan');
        $totalModalTambahan = $dataModalTambahan->sum('jumlah');
        $totalKasKeluar = $dataKasKeluar->sum('jumlah');
        $totalBOP = $dataBOP->sum('bop_pesanan');

        // Hitung laba rugi
        $labaRugi = $totalPenjualan + $totalModalTambahan - $totalKasKeluar - $totalBOP;

        // Gunakan tanggal awal dan akhir dalam nama file
        $nama_file = 'laba_rugi_' . $tanggal . '.pdf';

        // Buat PDF
        $pdf = PDF::loadView('auth.laporan.print.laba_rugi_pdf', compact('totalPenjualan', 'totalModalTambahan', 'totalKasKeluar', 'totalBOP', 'labaRugi', 'tanggal'))
            ->setPaper('a4', 'portrait');


        return $pdf->stream($nama_file);
    }

    public function excelLabaRugi(Request $request)
    {
        // Mulai query untuk transaksi pendapatan penjualan
        $queryPenjualan = Pesanan::query();

        // Mulai query untuk modal tambahan
        $queryModalTambahan = Keuangan::where('jenis', 'debet');

        // Mulai query untuk kas keluar
        $queryKasKeluar = Keuangan::where('jenis', 'kredit');

        // Mulai query untuk BOP
        $queryBOP = Pesanan::query();

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal')) {
            $tanggal = $request->tanggal;

            // Filter berdasarkan tanggal tertentu (menggunakan whereDate untuk mencocokkan tanggal secara tepat)
            $queryPenjualan = $queryPenjualan->whereDate('tanggal_pesanan', '=', $tanggal);
            $queryModalTambahan = $queryModalTambahan->whereDate('tanggal', '=', $tanggal);
            $queryKasKeluar = $queryKasKeluar->whereDate('tanggal', '=', $tanggal);
            $queryBOP = $queryBOP->whereDate('tanggal_pesanan', '=', $tanggal);
        } else {
            // Jika tidak ada tanggal yang dipilih, default ke hari ini
            $tanggal = Carbon::today()->format('Y-m-d'); // Format tanggal hari ini (YYYY-MM-DD)

            // Filter berdasarkan tanggal hari ini
            $queryPenjualan = $queryPenjualan->whereDate('tanggal_pesanan', '=', $tanggal);
            $queryModalTambahan = $queryModalTambahan->whereDate('tanggal', '=', $tanggal);
            $queryKasKeluar = $queryKasKeluar->whereDate('tanggal', '=', $tanggal);
            $queryBOP = $queryBOP->whereDate('tanggal_pesanan', '=', $tanggal);
        }

        // Dapatkan semua data dari setiap query
        $dataPenjualan = $queryPenjualan->get();
        $dataModalTambahan = $queryModalTambahan->get();
        $dataKasKeluar = $queryKasKeluar->get();
        $dataBOP = $queryBOP->get();

        // Hitung total dari masing-masing komponen
        $totalPenjualan = $dataPenjualan->sum('harga_pesanan');
        $totalModalTambahan = $dataModalTambahan->sum('jumlah');
        $totalKasKeluar = $dataKasKeluar->sum('jumlah');
        $totalBOP = $dataBOP->sum('bop_pesanan');

        // Hitung laba rugi
        $totalLabaKotor = $totalPenjualan + $totalModalTambahan;
        $labaRugi = $totalPenjualan + $totalModalTambahan - $totalKasKeluar - $totalBOP;

        // Membuat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan judul di A2
        $sheet->setCellValue('A2', 'LABA RUGI')->mergeCells('A2:B2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');
        $sheet->setCellValue('A3', 'Tanggal : ' . $tanggal)->mergeCells('A3:B3');
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('left');

        // Menetapkan judul kolom
        $sheet->setCellValue('A5', 'PENDAPATAN PENJUALAN');
        $sheet->setCellValue('A6', 'TAMBAHAN MODAL');
        $sheet->getStyle('A5:A6')->getFont()->setBold(true);
        $sheet->setCellValue('A7', 'JUMLAH TAMBAHAN MODAL');
        $sheet->setCellValue('A8', 'LABA KOTOR');
        $sheet->setCellValue('A9', 'PENGELUARAN/PENGURANGAN');
        $sheet->getStyle('A8:A9')->getFont()->setBold(true);
        $sheet->setCellValue('A10', 'BOP PENGIRIMAN');
        $sheet->setCellValue('A11', 'KAS KELUAR');
        $sheet->setCellValue('A12', 'LABA BERSIH');
        $sheet->getStyle('A12')->getFont()->setBold(true);

        // Menetapkan Isi
        // Mengatur format rupiah untuk totalPenjualan
        $sheet->setCellValue('B5', 'Rp. ' . number_format($totalPenjualan, 0, ',', '.'));
        $sheet->getStyle('B5')->getFont()->setBold(true);
        $sheet->getStyle('B5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        // Mengatur format rupiah untuk totalModalTambahan
        $sheet->setCellValue('B7', 'Rp. ' . number_format($totalModalTambahan, 0, ',', '.') . ' (+)');
        $sheet->getStyle('B7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        // Mengatur format rupiah untuk totalLabaKotor
        $sheet->setCellValue('B8', 'Rp. ' . number_format($totalLabaKotor, 0, ',', '.'));
        $sheet->getStyle('B8')->getFont()->setBold(true);
        $sheet->getStyle('B8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        // Mengatur format rupiah untuk totalBOP
        $sheet->setCellValue('B10', 'Rp. ' . number_format($totalBOP, 0, ',', '.') . ' (-)');
        $sheet->getStyle('B10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        // Mengatur format rupiah untuk totalKasKeluar
        $sheet->setCellValue('B11', 'Rp. ' . number_format($totalKasKeluar, 0, ',', '.') . ' (-)');
        $sheet->getStyle('B11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        // Mengatur format rupiah untuk labaRugi
        $sheet->setCellValue('B12', 'Rp. ' . number_format($labaRugi, 0, ',', '.'));
        $sheet->getStyle('B12')->getFont()->setBold(true);
        $sheet->getStyle('B12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Mengatur format header
        $sheet->getStyle('A5:B12')->getAlignment()->setVertical('center'); // Vertical Align Center

        // Mengatur lebar kolom
        $sheet->getColumnDimension('A')->setWidth(80);
        $sheet->getColumnDimension('B')->setWidth(50);

        // Mengatur tinggi kolom
        for ($row = 5; $row <= 12; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(25);
        }

        // Menambahkan border pada semua sel
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A5:B12')->applyFromArray($styleArray);

        // Mengatur warna latar belakang dan
        $sheet->getStyle('A12:B12')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'e12c6c'],
            ],
            'font' => [
                'color' => ['argb' => 'FFFFFF'],
            ],
        ]);
        $sheet->getStyle('A5:B5')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'e7e7e7'], // Warna latar belakang #e7e7e7
            ],
        ]);
        $sheet->getStyle('A8:B8')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'e7e7e7'], // Warna latar belakang #e7e7e7
            ],
        ]);

        // Menentukan format header
        $filename = 'laba_rugi_' . $tanggal . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function indexBukuBesar(Request $request)
    {
        $data['title'] = 'Buku Besar';

        // Set perPage berdasarkan permintaan pengguna atau default 10
        $perPage_data = $request->input('perPage_data', 10);

        // Mulai query untuk masing-masing kategori data
        $queryPenjualan = Pesanan::whereHas('pengiriman', function ($query) {
            $query->where('status_pengiriman', 'Diterima');
        })
            ->where('harga_pesanan', '!=', 0);
        $queryModalTambahan = Keuangan::where('jenis', 'debet');
        $queryKasKeluar = Keuangan::where('jenis', 'kredit');
        // $queryBOP = Pesanan::query();
        $queryBOP = Penarikanbop::query();

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir_full_day = Carbon::parse($request->tanggal_akhir)->endOfDay();
        } else {
            $tanggal_awal = Carbon::today();
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();
        }

        $queryPenjualan->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
        $queryModalTambahan->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
        $queryKasKeluar->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
        // $queryBOP->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
        $queryBOP->whereBetween('tanggal_penarikan', [$tanggal_awal, $tanggal_akhir_full_day]);

        // Dapatkan data dari setiap query
        $dataPenjualan = $queryPenjualan->get();
        $dataModalTambahan = $queryModalTambahan->get();
        $dataKasKeluar = $queryKasKeluar->get();
        $dataBOP = $queryBOP->get();

        // Gabungkan data dalam satu array
        $mergedData = [];

        // Data Penjualan (Pemasukan)
        foreach ($dataPenjualan as $index => $penjualan) {
            $mergedData[] = [
                'tanggal' => $penjualan->tanggal_pesanan,
                'kategori' => 'Debet',
                'keterangan' => 'Transaksi Penjualan',
                'debet' => $penjualan->harga_pesanan,
                'kredit' => 0,
            ];
        }

        // Data Modal Tambahan (Pemasukan)
        foreach ($dataModalTambahan as $index => $modal) {
            $mergedData[] = [
                'tanggal' => $modal->tanggal,
                'kategori' => 'Debet',
                'keterangan' => 'Modal Masuk',
                'debet' => $modal->jumlah,
                'kredit' => 0,
            ];
        }

        // Data Kas Keluar (Pengeluaran)
        foreach ($dataKasKeluar as $index => $kasKeluar) {
            $mergedData[] = [
                'tanggal' => $kasKeluar->tanggal,
                'kategori' => 'Kredit',
                'keterangan' => 'Kas Keluar',
                'debet' => 0,
                'kredit' => $kasKeluar->jumlah,
            ];
        }

        // Data BOP (Pengeluaran)
        foreach ($dataBOP as $index => $bop) {
            $mergedData[] = [
                'tanggal' => $bop->tanggal_penarikan,
                'kategori' => 'Kredit',
                'keterangan' => 'Penarikan BOP',
                'debet' => 0,
                'kredit' => $bop->jumlah_penarikan,
            ];
        }

        // Urutkan berdasarkan tanggal
        usort($mergedData, function ($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });

        // Paginasi secara manual dengan array
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = collect($mergedData);
        $data_table = new LengthAwarePaginator(
            $collection->forPage($currentPage, $perPage_data),
            $collection->count(),
            $perPage_data,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $totalDebet = $data_table->sum('debet');  // Jika 'debet' ada di dalam kolom data
        $totalKredit = $data_table->sum('kredit');  // Jika 'kredit' ada di dalam kolom data

        return view('auth.laporan.buku_besar', [
            'perPage_data' => $perPage_data,
            'data_table' => $data_table,
            'totalDebet' => $totalDebet,
            'totalKredit' => $totalKredit,
        ], $data);
    }

    public function pdfBukuBesar(Request $request)
    {
        // Mulai query untuk masing-masing kategori data
        $queryPenjualan = Pesanan::whereHas('pengiriman', function ($query) {
            $query->where('status_pengiriman', 'Diterima');
        })
            ->where('harga_pesanan', '!=', 0);
        $queryModalTambahan = Keuangan::where('jenis', 'debet');
        $queryKasKeluar = Keuangan::where('jenis', 'kredit');
        // $queryBOP = Pesanan::query();
        $queryBOP = Penarikanbop::query();

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $tanggal_akhir_full_day = Carbon::parse($request->tanggal_akhir)->endOfDay();

            $queryPenjualan->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
            $queryModalTambahan->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
            $queryKasKeluar->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
            // $queryBOP->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
            $queryBOP->whereBetween('tanggal_penarikan', [$tanggal_awal, $tanggal_akhir_full_day]);
        } else {
            $tanggal_awal = Carbon::today()->format('Y-m-d');
            $tanggal_akhir = Carbon::today()->format('Y-m-d');
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();

            $queryPenjualan->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
            $queryModalTambahan->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
            $queryKasKeluar->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
            // $queryBOP->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
            $queryBOP->whereBetween('tanggal_penarikan', [$tanggal_awal, $tanggal_akhir_full_day]);
        }

        // Dapatkan data dari setiap query
        $dataPenjualan = $queryPenjualan->get();
        $dataModalTambahan = $queryModalTambahan->get();
        $dataKasKeluar = $queryKasKeluar->get();
        $dataBOP = $queryBOP->get();

        // Gabungkan data dalam satu array
        $mergedData = [];

        // Data Penjualan (Pemasukan)
        foreach ($dataPenjualan as $index => $penjualan) {
            $mergedData[] = [
                'tanggal' => $penjualan->tanggal_pesanan,
                'kategori' => 'Debet',
                'keterangan' => 'Transaksi Penjualan',
                'debet' => $penjualan->harga_pesanan,
                'kredit' => 0,
            ];
        }

        // Data Modal Tambahan (Pemasukan)
        foreach ($dataModalTambahan as $index => $modal) {
            $mergedData[] = [
                'tanggal' => $modal->tanggal,
                'kategori' => 'Debet',
                'keterangan' => 'Modal Masuk',
                'debet' => $modal->jumlah,
                'kredit' => 0,
            ];
        }

        // Data Kas Keluar (Pengeluaran)
        foreach ($dataKasKeluar as $index => $kasKeluar) {
            $mergedData[] = [
                'tanggal' => $kasKeluar->tanggal,
                'kategori' => 'Kredit',
                'keterangan' => 'Kas Keluar',
                'debet' => 0,
                'kredit' => $kasKeluar->jumlah,
            ];
        }

        // Data BOP (Pengeluaran)
        foreach ($dataBOP as $index => $bop) {
            $mergedData[] = [
                'tanggal' => $bop->tanggal_penarikan,
                'kategori' => 'Kredit',
                'keterangan' => 'Penarikan BOP',
                'debet' => 0,
                'kredit' => $bop->jumlah_penarikan,
            ];
        }

        // Urutkan berdasarkan tanggal
        usort($mergedData, function ($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });

        // Paginasi secara manual dengan array
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $data_table = collect($mergedData);

        $totalDebet = $data_table->sum('debet');  // Jika 'debet' ada di dalam kolom data
        $totalKredit = $data_table->sum('kredit');  // Jika 'kredit' ada di dalam kolom data

        // Gunakan tanggal awal dan akhir dalam nama file
        $nama_file = 'buku_besar_' . $tanggal_awal . '_sd_' . $tanggal_akhir . '.pdf';

        // Buat PDF
        $pdf = PDF::loadView('auth.laporan.print.buku_besar_pdf', compact('data_table', 'tanggal_awal', 'tanggal_akhir', 'totalDebet', 'totalKredit'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream($nama_file);
    }

    private function mergeDataExcel($request)
    {
        // Mulai query untuk masing-masing kategori data
        $queryPenjualan = Pesanan::whereHas('pengiriman', function ($query) {
            $query->where('status_pengiriman', 'Diterima');
        })
            ->where('harga_pesanan', '!=', 0);
        $queryModalTambahan = Keuangan::where('jenis', 'debet');
        $queryKasKeluar = Keuangan::where('jenis', 'kredit');
        // $queryBOP = Pesanan::query();
        $queryBOP = Penarikanbop::query();

        // Tambahkan filter tanggal jika ada
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir_full_day = Carbon::parse($request->tanggal_akhir)->endOfDay();
        } else {
            $tanggal_awal = Carbon::today()->format('Y-m-d');
            $tanggal_akhir_full_day = Carbon::today()->endOfDay();
        }

        $queryPenjualan->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir_full_day]);
        $queryModalTambahan->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
        $queryKasKeluar->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir_full_day]);
        $queryBOP->whereBetween('tanggal_penarikan', [$tanggal_awal, $tanggal_akhir_full_day]);

        // Dapatkan data dari setiap query
        $dataPenjualan = $queryPenjualan->get();
        $dataModalTambahan = $queryModalTambahan->get();
        $dataKasKeluar = $queryKasKeluar->get();
        $dataBOP = $queryBOP->get();
        $mergedData = [];

        // Data Penjualan (Pemasukan)
        foreach ($dataPenjualan as $index => $penjualan) {
            $mergedData[] = [
                'tanggal' => $penjualan->tanggal_pesanan,
                'kategori' => 'Debet',
                'keterangan' => 'Transaksi Penjualan',
                'debet' => $penjualan->harga_pesanan,
                'kredit' => 0,
            ];
        }

        // Data Modal Tambahan (Pemasukan)
        foreach ($dataModalTambahan as $index => $modal) {
            $mergedData[] = [
                'tanggal' => $modal->tanggal,
                'kategori' => 'Debet',
                'keterangan' => 'Modal Masuk',
                'debet' => $modal->jumlah,
                'kredit' => 0,
            ];
        }

        // Data Kas Keluar (Pengeluaran)
        foreach ($dataKasKeluar as $index => $kasKeluar) {
            $mergedData[] = [
                'tanggal' => $kasKeluar->tanggal,
                'kategori' => 'Kredit',
                'keterangan' => 'Kas Keluar',
                'debet' => 0,
                'kredit' => $kasKeluar->jumlah,
            ];
        }

        // Data BOP (Pengeluaran)
        foreach ($dataBOP as $index => $bop) {
            $mergedData[] = [
                'tanggal' => $bop->tanggal_pesanan,
                'kategori' => 'Kredit',
                'keterangan' => 'Penarikan BOP',
                'debet' => 0,
                'kredit' => $bop->bop_pesanan,
            ];
        }

        return $mergedData;
    }

    public function excelBukuBesar(Request $request)
    {
        // Gabungkan data dalam satu array
        $mergedData = $this->mergeDataExcel($request);

        // Urutkan berdasarkan tanggal
        usort($mergedData, function ($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });

        // Paginasi secara manual dengan array
        $data_table = collect($mergedData);

        $totalDebet = $data_table->sum('debet');  // Jika 'debet' ada di dalam kolom data
        $totalKredit = $data_table->sum('kredit');  // Jika 'kredit' ada di dalam kolom data
        $totalLaba = $totalDebet - $totalKredit;

        // Membuat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan judul di A2
        $sheet->setCellValue('A2', 'BUKU BESAR')->mergeCells('A2:C2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');

        // Menambahkan periode tanggal di A3
        $tanggalPesanan = $data_table->pluck('tanggal_pesanan')->map(function ($date) {
            return Carbon::parse($date);
        });
        $tanggalAwal = $tanggalPesanan->min()->format('d-M-Y');
        $tanggalAkhir = $tanggalPesanan->max()->format('d-M-Y');

        $sheet->setCellValue('A3', 'Tanggal : ' . $tanggalAwal . ' sd ' . $tanggalAkhir)->mergeCells('A3:C3');
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('left');

        // Menetapkan judul kolom
        $sheet->setCellValue('A5', 'No');
        $sheet->setCellValue('B5', 'Tanggal');
        $sheet->setCellValue('C5', 'Kategori');
        $sheet->setCellValue('D5', 'Keterangan');
        $sheet->setCellValue('E5', 'Debet');
        $sheet->setCellValue('F5', 'Kredit');

        // Mengatur format header
        $sheet->getStyle('A5:F5')->getFont()->setBold(true);
        $sheet->getStyle('A5:F5')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A5:F5')->getAlignment()->setVertical('center'); // Vertical Align Center

        // Mengisi data
        $row = 6;

        foreach ($data_table as $index => $keuangan) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal('left');
            $tanggalPesanan = Carbon::parse($keuangan['tanggal']);
            $sheet->setCellValue('B' . $row, $tanggalPesanan->format('d-M-Y H:i'));
            if ($keuangan['kategori'] === 'Debet') {
                // Set font warna hijau untuk kategori Debet
                $sheet->setCellValue('C' . $row, $keuangan['kategori']);
                $sheet->getStyle('C' . $row)->getFont()->getColor()->setRGB('28a745'); // Hijau
            } elseif ($keuangan['kategori'] === 'Kredit') {
                // Set font warna merah untuk kategori Kredit
                $sheet->setCellValue('C' . $row, $keuangan['kategori']);
                $sheet->getStyle('C' . $row)->getFont()->getColor()->setRGB('dc3545'); // Merah
            } else {
                // Set font warna default jika kategori bukan Debet atau Kredit
                $sheet->setCellValue('C' . $row, $keuangan['kategori']);
                $sheet->getStyle('C' . $row)->getFont()->getColor()->setRGB('000000'); // Hitam (default)
            }
            $sheet->setCellValue('D' . $row, $keuangan['keterangan']);
            $sheet->setCellValue('E' . $row, $keuangan['debet'] ?? 0);
            $sheet->setCellValue('F' . $row, $keuangan['kredit'] ?? 0);

            $row++;
        }

        // Set "Total Laba" dengan rowspan 2, mulai dari baris $row
        $sheet->setCellValue('A' . $row, 'Total Laba')
            ->mergeCells('A' . $row . ':D' . ($row + 1)); // Menambahkan rowspan 2 untuk kolom A        
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row . ':A' . ($row + 1))->getAlignment()->setVertical('center'); // Vertical center for rowspan

        // Set Total Debet dan Total Kredit di baris pertama
        $sheet->setCellValue('E' . $row, $totalDebet);
        $sheet->getStyle('E' . $row)->getFont()->setBold(false); // Menghilangkan bold
        $sheet->getStyle('E' . $row)->getFont()->getColor()->setRGB('28a745'); // Hijau untuk Total Debet
        $sheet->setCellValue('F' . $row, $totalKredit);
        $sheet->getStyle('F' . $row)->getFont()->setBold(false); // Menghilangkan bold
        $sheet->getStyle('F' . $row)->getFont()->getColor()->setRGB('dc3545'); // Merah untuk Total Kredit
        $sheet->getStyle('E' . $row . ':F' . $row)->getAlignment()->setHorizontal('center'); // Center align

        // Pindah ke baris berikutnya
        $row++;

        // Set Total Laba di baris berikutnya dengan colspan 2 (E dan F)
        $sheet->setCellValue('E' . $row, $totalLaba);
        $sheet->mergeCells('E' . $row . ':F' . $row); // Merge untuk Total Laba
        $sheet->getStyle('E' . $row)->getFont()->setBold(true);
        $sheet->getStyle('E' . $row . ':F' . $row)->getAlignment()->setHorizontal('center'); // Center align Total Laba
        $sheet->getStyle('A' . $row . ':F' . $row)->getAlignment()->setVertical('center'); // Vertical align center untuk seluruh baris

        // Mengatur lebar kolom agar sesuai dengan konten, kecuali kolom D
        foreach (range('A', 'F') as $column) {
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
        $sheet->getStyle('A5:F' . ($row))->applyFromArray($styleArray);

        // Mengatur alignment teks untuk seluruh kolom agar vertikal tengah
        $sheet->getStyle('A5:F' . $row)->getAlignment()->setVertical('center');

        // Mengatur warna latar belakang dan teks di L5
        $sheet->getStyle('A5:F5')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'e12c6c'],
            ],
            'font' => [
                'color' => ['argb' => 'FFFFFF'],
            ],
        ]);

        // Menentukan format header
        $filename = 'buku_besar_' . $tanggalAwal . '_sd_' . $tanggalAkhir . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}