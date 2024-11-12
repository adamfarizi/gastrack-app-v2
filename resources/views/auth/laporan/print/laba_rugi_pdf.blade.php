<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/local/logo1.png') }}">
    <title>Laba Rugi | Tanggal: {{ $tanggal }}</title>
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
                    <p class="mb-0"><strong>LABA RUGI</strong></p>
                    <p style="font-size: 12px;">Tanggal: {{ $tanggal }}</p>
                </div>
            </td>
        </tr>
    </table>
    <hr class="border" style="width: 100%; color: #cccfd6;">
    <div>
        <table class="table table-sm table-bordered">
            <tbody style="font-size: 11px">
                <tr style="border-bottom: 1px solid #ddd; background-color:#e7e7e7 ">
                    <td style="border-right: 1px solid #ddd; padding: 8px; vertical-align: middle;">
                        <p class="mb-0 text-dark fw-bold">PENDAPATAN PENJUALAN</p>
                    </td>
                    <td style="padding: 8px; vertical-align: middle;">
                        <p class="mb-0 text-dark fw-bold">Rp.
                            {{ number_format($totalPenjualan ?? 0, 0, ',', '.') }}</p>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="border-right: 1px solid #ddd; padding: 8px; vertical-align: middle;">
                        <p class="mb-0 text-dark fw-bold">TAMBAHAN MODAL</p>
                    </td>
                    <td style="padding: 8px; vertical-align: middle;"></td>
                </tr>
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="border-right: 1px solid #ddd; padding: 8px; vertical-align: middle;">
                        <p class="mb-0 text-dark">JUMLAH TAMBAHAN MODAL</p>
                    </td>
                    <td style="padding: 8px; vertical-align: middle;">
                        <p class="mb-0 text-dark">Rp.
                            {{ number_format($totalModalTambahan ?? 0, 0, ',', '.') }} (+)</p>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #ddd; background-color:#e7e7e7 ">
                    <td style="border-right: 1px solid #ddd; padding: 8px; vertical-align: middle;">
                        <p class="mb-0 text-dark fw-bold">LABA KOTOR</p>
                    </td>
                    <td style="padding: 8px; vertical-align: middle;">
                        <p class="mb-0 text-dark fw-bold">Rp.
                            {{ number_format($totalPenjualan + $totalModalTambahan ?? 0, 0, ',', '.') }}
                        </p>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="border-right: 1px solid #ddd; padding: 8px; vertical-align: middle;">
                        <p class="mb-0 text-dark fw-bold">PENGELUARAN/PENGURANGAN</p>
                    </td>
                    <td style="padding: 8px; vertical-align: middle;"></td>
                </tr>
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="border-right: 1px solid #ddd; padding: 8px; vertical-align: middle;">
                        <p class="mb-0 text-dark">BOP PENGIRIMAN</p>
                    </td>
                    <td style="padding: 8px; vertical-align: middle;">
                        <p class="mb-0 text-dark">Rp. {{ number_format($totalBOP ?? 0, 0, ',', '.') }} (-)
                        </p>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="border-right: 1px solid #ddd; padding: 8px; vertical-align: middle;">
                        <p class="mb-0 text-dark">KAS KELUAR</p>
                    </td>
                    <td style="padding: 8px; vertical-align: middle;">
                        <p class="mb-0 text-dark">Rp.
                            {{ number_format($totalKasKeluar ?? 0, 0, ',', '.') }} (-)</p>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #ddd; background-color: #e91e63;">
                    <td style="border-right: 1px solid #ddd; padding: 8px; vertical-align: middle;">
                        <p class="mb-0 text-white fw-bold">LABA BERSIH</p>
                    </td>
                    <td style="padding: 8px; vertical-align: middle;">
                        <p class="mb-0 text-white fw-bold">Rp.
                            {{ number_format($labaRugi ?? 0, 0, ',', '.') }}</p>
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
