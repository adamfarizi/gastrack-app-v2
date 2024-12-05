<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/local/logo1.png') }}">
    <title>Data Pesanan Turbin | {{ $transaksi->pelanggan->nama_perusahaan }}</title>
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
    <table style="width: 100%;">
        <tr>
            <td style="width: 150px; vertical-align: top;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/local/logo5.png'))) }}"
                    alt="main_logo" style="width: 100%;">
            </td>
            <td style="vertical-align: top; text-align: right;">
                <div>
                    <p class="mb-0"><strong>REKAPITULASI PESANAN GAS</strong></p>
                    <p style="font-size: 12px;">Customer : {{ $transaksi->pelanggan->nama_perusahaan }}</p>
                </div>
            </td>
        </tr>
    </table>
    <hr class="border" style="width: 100%; color: #cccfd6;">
    <div>
        <table class="table table-sm table-bordered">
            <thead class="text-center" style="font-size: 12px">
                <tr>
                    <th class="px-0 align-middle">No</th>
                    <th class="px-0 align-middle">Pelanggan</th>
                    <th class="px-0 align-middle">Hari Pemesanan</th>
                    <th class="px-0 align-middle">Tanggal Pemesanan</th>
                    <th class="px-0 align-middle">Waktu Pemesanan</th>
                    <th class="px-0 align-middle">Diantar Oleh</th>
                </tr>
            </thead>
            <tbody style="font-size: 11px;">
                @forelse ($pesanans_normal as $pesanan)
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
                            <p>{{ $pesanan->transaksi->pelanggan->nama_perusahaan }}</p>
                        </td>
                        <td>
                            <p>{{ $hari }}</p>
                        </td>
                        <td>
                            <p>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d-M-Y') }}</p>
                        </td>
                        <td>
                            <p>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('H:i:s') }}</p>
                        </td>
                        <td>
                            <p>{{ $pesanan->pengiriman->sopir ? $pesanan->pengiriman->sopir->nama : 'Belum Dikirim' }}
                            </p>
                            <p>{{ $pesanan->pengiriman->mobil ? $pesanan->pengiriman->mobil->nopol_mobil : 'Belum Dikirim' }}
                            </p>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data pesanan.</td>
                    </tr>
                @endforelse
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
