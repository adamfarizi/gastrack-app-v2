<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/local/logo1.png') }}">
    <title>Invoice {{ $transaksi->pelanggan->nama_perusahaan }} bulan {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('M Y') }}</title>
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

        .invoice-table {
            border-collapse: collapse;
            width: 100%;
        }
        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .invoice-table th {
            background-color: transparent;
        }

        .border {
            border: 1px solid #ddd;
            padding: 8px;
        }

        @media print {
            table {
                width: 100%;
                page-break-inside: auto;
            }

            th,
            td {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="mb-3">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div style="width: 150px; vertical-align: top;">
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/local/logo5.png'))) }}"
                            alt="main_logo" style="width: 100%;">
                    </div>
                    <p style="font-size: 12px; text-decoration: underline;"><strong>SURYA INDEPENDEN ENERGI
                            GEMILANG</strong></p>
                </td>
                <td>
                    <div style="vertical-align: top; text-align: right;">
                        <h3 class="mb-0"><strong>INVOICE</strong></h3>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="mb-3">
        <table class="mx-3" style="width: 100%;">
            <tbody style="font-size: 13px;">
                <tr>
                    <td colspan="2" style="width: 50%; vertical-align: top;"><strong>Customer</strong></td>
                    <td style="width: 15%; vertical-align: top;">Invoice No.</td>
                    <td style="width: 35%; vertical-align: top;"><strong>{{ $transaksi->resi_transaksi }}</strong></td>
                </tr>
                <tr>
                    <td style="width: 10%; vertical-align: top;">Name</td>
                    <td style="width: 40%; vertical-align: top;">
                        <strong>{{ $transaksi->pelanggan->nama_perusahaan }}</strong>
                    </td>
                    <td style="width: 15%; vertical-align: top;">Date Invoice</td>
                    <td style="width: 35%; vertical-align: top;">
                        <strong>{{ \Carbon\Carbon::parse(now())->format('d-M-Y') }}</strong>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">Address</td>
                    <td style="vertical-align: top;"><strong>{{ $transaksi->pelanggan->alamat }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="mb-3">
        <table class="invoice-table">
            <thead style="font-size: 12px;">
                <tr>
                    <th class="px-0" style="text-align: center;">
                        Item
                    </th>
                    <th class="px-0" style="width: 50%; text-align: center;">
                        Description
                    </th>
                    <th class="px-0" style="text-align: center;">
                        M<sup>3</sup>
                    </th>
                    <th class="px-0" style="text-align: center;">
                        Unit Price (M<sup>3</sup>)
                    </th>
                    <th class="px-0" style="text-align: center;">
                        Total
                    </th>
                </tr>
            </thead>
            <tbody style="font-size: 12px;">
                @if ($transaksi)
                    <tr style="text-align: right; vertical-align: top;">
                        <td style="text-align: center">
                            <p>1</p>
                        </td>
                        <td style="text-align: left; height: 300px">
                            <p>SUPPLY<br>COMPRESSED NATURAL GAS (CNG)<br><br>periode :
                                {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('M Y') }}</p>
                        </td>
                        <td>
                            <p>{{ $totalJumlahM3 ?? 0 }}</p>
                        </td>
                        <td>
                            <p>Rp {{ number_format($transaksi->pelanggan->harga_pelanggan, 0, ',', '.') }}</p>
                        </td>
                        <td>
                            <p>Rp {{ number_format($totalHargaPesanan, 0, ',', '.') }}</p>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="5">Tidak ada data pesanan.</td>
                    </tr>
                @endif
                <tr style="font-size: 10px; margin: 0; padding: 0;">
                    <td colspan="2" rowspan="2" style="border: none; padding: 0; margin: 0;"></td>
                    <td style="padding: 0; margin: 0; text-align: left; padding-left: 2px;">Sub Total</td>
                    <td colspan="2" style="padding: 0; margin: 0;"></td>
                </tr>
                <tr style="font-size: 10px; margin: 0; padding: 0;">
                    <td style="padding: 0; margin: 0; text-align: left; padding-left: 2px;">PPN</td>
                    <td colspan="2" style="padding: 0; margin: 0;"></td>
                </tr>                
                <tr style="margin: 0; padding: 0;">
                    <td colspan="3" style="border: none; padding: 0; margin: 0;"></td>
                    <td style="text-align: center; border: none; padding: 0; margin: 0;">
                        <strong>TOTAL</strong>
                    </td>
                    <td style="text-align: right;padding: 0; margin: 0; padding-right: 5px;">
                        <strong>Rp {{ number_format($totalHargaPesanan, 0, ',', '.') }}</strong>
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>
    <div class="mb-3">
        <table style="width: 100%; font-size: 12px;">
            <tbody>
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <div class="border mr-5">
                            <p class="bg-warning px-2 pb-1" 
                                style="border: 1px solid black; font-size: 10px; box-sizing: border-box; color: black;">
                                <strong>Payment</strong> : <em>3 Days After Invoice Date</em>
                            </p>  
                            <p style="text-decoration: underline; text-align: center;"><strong>Please Transfer The Payment to :</strong></p>
                            <table style="width: 100%;">
                                <tr>
                                    <td style="text-align: right; width: 20%">Name : </td>
                                    <td style="border-bottom: 0.5px solid #344767;">
                                        <strong>{{ $master_payment->nama_master }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right; width: 20%">Bank : </td>
                                    <td style="border-bottom: 0.5px solid #344767;">
                                        <strong>{{ $master_payment->bank_master }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right; width: 20%">KCU : </td>
                                    <td style="border-bottom: 0.5px solid #344767;">
                                        <strong>{{ $master_payment->kcu_master }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right; width: 20%">Account : </td>
                                    <td style="border-bottom: 0.5px solid #344767;">
                                        <strong>{{ $master_payment->account_master }}</strong>
                                    </td>
                                </tr>
                            </table>                                           
                        </div>
                    </td>
                    <td style="width: 50%; vertical-align: top;">
                        <table style="width: 100%;">    
                            <tr>
                                <td style="vertical-align: top; padding: 0; border: 1px solid #ddd; width: 25%">
                                    <p class="ml-2" style="text-align: left;">
                                        <strong><em style="text-decoration: underline;">Says :</em></strong>
                                    </p>
                                </td>
                                <td style="vertical-align: top; padding: 0; border: 1px solid #ddd;">
                                    <p class="ml-2" style="text-align: left;">
                                        <em># {{ $totalTerbilang }}</em>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>                
                </tr>
            </tbody>
        </table>        
    </div>
    <div class="mb-3">
        <table style="width: 100%; font-size: 12px;">
            <tbody>
                <tr>
                    <td style="width: 50%"></td>
                    <td style="width: 50%">
                        <div>
                            <p style="text-align: center">
                                PT SURYA INDEPENDEN ENERGI GEMILANG
                            </p>
                            <div style="height: 100px"></div>
                            <p style="text-align: center; text-decoration: underline">
                                Hartono
                            </p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        <hr class="mb-0 p-0">
        <p class="p-0 m-0" style="font-size: 10px; text-align: center;">Any question regarding this invoice, please call Hartono: HP. 081515789898 Email : hartono.eka@gmail.com</p>
    </div>
</body>

</html>
