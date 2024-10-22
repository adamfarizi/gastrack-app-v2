<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/local/logo1.png') }}">
    <title>Data Pesanan {{ $transaksi->pelanggan->nama_perusahaan }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    </style>
    <style>
        body {
            font-family: "Roboto", sans-serif;
        }

        body,
        p {
            color: #344767;
        }

        @media print {
            table {
                width: 100%;
                /* Memastikan tabel menggunakan lebar penuh */
                page-break-inside: auto;
                /* Menghindari pemotongan tabel saat mencetak */
            }

            th,
            td {
                page-break-inside: avoid;
                /* Menghindari pemotongan sel saat mencetak */
            }
        }
    </style>
</head>

<body>
    <div>
        <p class="mb-0"><strong>REKAPITULASI PESANAN GAS</strong></p>
        <p style="font-size: 12px;">Customer : {{ $transaksi->pelanggan->nama_perusahaan }}</p>
    </div>
    <hr class="border" style="width: 100%; color: #cccfd6;">
    <div>
        <table class="table table-sm table-bordered">
            <thead class="text-center" style="font-size: 12px">
                <tr>
                    <th class="px-0 align-middle" rowspan="2">No</th>
                    <th class="px-0 align-middle" rowspan="2" style="width: 10%">Resi</th>
                    <th class="px-0 align-middle" rowspan="2">Hari</th>
                    <th class="px-0 align-middle" rowspan="2">Tanggal</th>
                    <th class="px-0 align-middle" rowspan="2">Pelanggan</th>
                    <th class="px-0 align-middle" rowspan="2">No. Pol</th>
                    <th class="px-0 align-middle" colspan="4">Tekanan</th>
                    <th class="px-0 align-middle" rowspan="2">Volume<br>LWC/m<sup>3</sup></th>
                    <th class="px-0 align-middle" rowspan="2">Total Harga</th>
                </tr>
                <tr>
                    <th class="px-0">Awal</th>
                    <th class="px-0">Akhir</th>
                    <th class="px-0">Selisih</th>
                    <th class="px-0">LWC</th>
                </tr>
            </thead>
            <tbody style="font-size: 11px;">
                @forelse ($pesanans as $pesanan)
                    @php
                        // Daftar nama hari dan bulan dalam Bahasa Indonesia
                        $namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        // Mengubah string tanggal ke timestamp
                        $timestamp = strtotime($pesanan->tanggal_pesanan);
                        // Mengambil nama hari dan tanggal
                        $hari = $namaHari[date('w', $timestamp)];
                    @endphp
                    <tr>
                        <td>
                            <p>{{ $loop->iteration }}</p>
                        </td>
                        <td>
                            <p>{{ $pesanan->pengiriman->kode_pengiriman }}</p>
                        </td>
                        <td>
                            <p>{{ $hari }}</p>
                        </td>
                        <td>
                            <p>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d-M-Y') }}</p>
                        </td>
                        <td>
                            <p>{{ $pesanan->transaksi->pelanggan->nama_perusahaan }}</p>
                        </td>
                        <td>
                            <p>{{ $pesanan->pengiriman->mobil ? $pesanan->pengiriman->mobil->nopol_mobil : 'Belum Dikirim' }}
                            </p>
                        </td>
                        <td>
                            <p>{{ $pesanan->pengiriman->kapasitas_gas_masuk ?? 0 }}</p>
                        </td>
                        <td>
                            <p>{{ $pesanan->pengiriman->sisa_gas ?? 0 }}</p>
                        </td>
                        <td>
                            <p>{{ $pesanan->pengiriman->kapasitas_gas_keluar ?? 0 }}</p>
                        </td>
                        <td>
                            <p>0</p>
                        </td>
                        <td>
                            <p>{{ $pesanan->jumlah_m3 ?? 0 }}</p>
                        </td>
                        <td>
                            <p>Rp {{ number_format($pesanan->harga_pesanan, 0, ',', '.') }}</p>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">Tidak ada data pesanan.</td>
                    </tr>
                @endforelse
                <tr>
                    <th class="text-center align-middle" colspan="10">Jumlah</th>
                    <td class="align-middle">
                        <p>{{ $totalJumlahM3 ?? 0 }}</p>
                    </td>
                    <td class="align-middle">
                        <p>Rp {{ number_format($totalHargaPesanan, 0, ',', '.') }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
