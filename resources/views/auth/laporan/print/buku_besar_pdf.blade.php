<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/local/logo1.png') }}">
    <title>Omzet Penjualan | Tanggal: {{ $tanggal_awal }} sd {{ $tanggal_akhir }}</title>
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
                    <p class="mb-0"><strong>OMZET PENJUALAN</strong></p>
                    <p style="font-size: 12px;">Tanggal: {{ $tanggal_awal }} sd {{ $tanggal_akhir }}</p>
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
                    <th class="px-0 align-middle">Tanggal</th>
                    <th class="px-0 align-middle">Kategori</th>
                    <th class="px-0 align-middle">Keterangan</th>
                    <th class="px-0 align-middle">Debet</th>
                    <th class="px-0 align-middle">Kredit</th>
                </tr>
            </thead>
            <tbody style="font-size: 11px;">
                @forelse($data_table as $keuangan)
                    <tr>
                        <td>
                            <p>
                                {{ $loop->iteration }}
                            </p>
                        </td>
                        <td>
                            @php
                                // Mengonversi tanggal ke format yang diinginkan
                                $tanggalKeuangan = \Carbon\Carbon::parse($keuangan['tanggal']);
                                $formattedDate = $tanggalKeuangan->translatedFormat('d-M-Y'); // Format: Hari, tanggal-bulan-tahun
                                $formattedTime = $tanggalKeuangan->format('H:i'); // Format: Jam
                            @endphp
                            <p class="mb-0">{{ $formattedDate }}</p>
                            <p >Jam : {{ $formattedTime }}</p>
                        </td>
                        <td>
                            @if ($keuangan['kategori'] == 'Debet')
                                <p class="text-success">
                                    Debet
                                </p>
                            @else
                                <p class="text-danger">
                                    Kredit
                                </p>
                            @endif
                        </td>
                        <td>
                            <p>
                                {{ $keuangan['keterangan'] }}
                            </p>
                        </td>
                        <td>
                            <p> Rp. {{ number_format($keuangan['debet'], 0, ',', '.') }}
                            </p>
                        </td>
                        <td>
                            <p> Rp. {{ number_format($keuangan['kredit'], 0, ',', '.') }}
                            </p>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            <p class="mt-5 mb-5">Tidak ada data hari ini.</p>
                        </td>
                    </tr>
                @endforelse
            <tfoot
                style="border-top: 1px solid #f0f2f5; position: sticky; bottom: 0; z-index: 10; background-color:#f7f7f7; font-size: 11px;">
                <tr>
                    <td colspan="4" rowspan="2" class="text-center" style="vertical-align: middle;">
                        <p><strong>Total Laba</strong></p>
                    </td>
                    <td class="text-center">
                        <p class="text-success">Rp.
                            {{ number_format($totalDebet, 0, ',', '.') }}</p>
                    </td>
                    <td class="text-center">
                        <p class="text-danger">Rp.
                            {{ number_format($totalKredit, 0, ',', '.') }}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <p><strong>Rp. {{ number_format($totalDebet - $totalKredit, 0, ',', '.') }}</p>

                    </td>
                </tr>
            </tfoot>
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
