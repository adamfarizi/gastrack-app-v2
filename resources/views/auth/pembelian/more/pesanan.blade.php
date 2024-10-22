@extends('app')
@section('sidebar')
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-white">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0 text-center p-0" href="">
                <div class="px-5 py-3">
                    <img class="img-fluid" src="{{ asset('assets/img/local/logo5.png') }}" alt="main_logo">
                </div>
            </a>
        </div>
        <hr class="horizontal dark mt-0 mb-2">
        {{-- Side Content --}}
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('/beranda') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Beranda</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white active bg-gradient-primary" href="{{ url('/pembelian') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">shopping_cart</i>
                        </div>
                        <span class="nav-link-text ms-1">Pembelian</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark " href="{{ url('/pengiriman') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-solid fa-dolly" style="color: #344767;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Pengiriman</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark " href="{{ url('/laporan') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Laporan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark " href="{{ url('/sopir&kendaraan') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">local_shipping</i>
                        </div>
                        <span class="nav-link-text ms-1">Sopir & Kendaraan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark " href="{{ url('/penarikan') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-symbols-outlined opacity-10">payments</i>
                        </div>
                        <span class="nav-link-text ms-1">Penarikan BOP</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8">Master Pengguna
                    </h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('/pengguna') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">group</i>
                        </div>
                        <span class="nav-link-text ms-1">Pelanggan</span>
                    </a>
                </li>
                @if (Auth::user()->role == 'Super Admin')
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ url('/pengguna_admin') }}">
                            <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">group</i>
                            </div>
                            <span class="nav-link-text ms-1">Admin</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8">Halaman Pengguna
                    </h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('/profil/' . Auth::user()->id_admin) }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <span class="nav-link-text ms-1">Profil</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidenav-footer position-absolute w-100 bottom-0 ">
            <div class="mx-3">
                <a class="btn bg-gradient-primary w-100" href="{{ url('logout') }}" type="button">Keluar</a>
            </div>
        </div>
    </aside>
@endsection
@section('navbar')
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
        data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark">Pembelian</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail Pesanan</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Detail Pesanan</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <ul class="navbar-nav justify-content-end me-5">
                        <div class="d-flex py-1">
                            <div class="my-auto">
                                <img src="{{ asset('../assets/img/local/profil.png') }}"
                                    class="border-radius-lg avatar-sm me-3 mt-1">
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                    <span class="font-weight-bold"> {{ Auth::user()->nama }} </span>
                                </h6>
                                <p class="text-xs text-secondary mb-0 ">
                                    <i class="fa fa-solid fa-circle" style="color: #82d616;"></i>
                                    Online
                                </p>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </a>
            </li>
        </div>
    </nav>
@endsection
@section('content')
    @foreach ($transaksis as $transaksi)
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card pb-4">
                    <div class="card-header pb-0">
                        <h4 class="text-primary">Detail Pesanan</h4>
                        <hr>
                    </div>
                    <div class="card-body px-3 pt-0 pb-3" style="min-height: 450px">
                        {{-- Header --}}
                        <div class="row mx-2">
                            <div class="mb-3 col-md-6">
                                <div class="row">
                                    <p class="col-4 fw-bold text-dark mb-0">Resi Transaksi</p>
                                    <p class="col fw-bold text-dark mb-0">: <span
                                            class="ms-1 col fw-light text-second">{{ $transaksi->resi_transaksi }}</span>
                                    </p>
                                </div>
                                <div class="row">
                                    <p class="col-4 fw-bold text-dark mb-0">Jatuh Tempo</p>
                                    <p class="col fw-bold text-dark mb-0">: <span
                                            class="ms-1 col fw-light text-second">{{ date('d/M/Y', strtotime($transaksi->tagihan->tanggal_jatuh_tempo)) }}</span>
                                    </p>
                                </div>
                                <div class="row">
                                    <p class="col-4 fw-bold text-dark mb-0">Waktu Mundur</p>
                                    <p class="col fw-bold text-dark mb-0">: <span class="ms-1 col fw-light text-second"
                                            id="countdown"></span></p>
                                </div>
                                <div class="row">
                                    <p class="col-4 fw-bold text-dark mb-0">Tanggal Pembayaran</p>
                                    @if ($transaksi->tagihan->status_tagihan === 'Sudah Bayar')
                                        <p class="col fw-bold text-dark mb-0">: <span
                                                class="ms-1 col fw-light text-second">{{ date('d/M/Y', strtotime($transaksi->tagihan->tanggal_pembayaran)) }}</span>
                                        @elseif ($transaksi->tagihan->status_tagihan === 'Diproses')
                                        <p class="col fw-bold text-dark mb-0">: <span
                                                class="ms-1 col fw-light text-warning">{{ date('d/M/Y', strtotime($transaksi->tagihan->tanggal_pembayaran)) }}
                                                (menunggu konfirmasi pembayaran)
                                            </span>
                                        @else
                                        <p class="col fw-bold text-dark mb-0">: <span
                                                class="ms-1 col fw-light text-danger">Belum Bayar</span>
                                    @endif
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3 col-md-5">
                                <div class="row">
                                    <p class="col-3 fw-bold text-dark mb-0">Pelanggan</p>
                                    <p class="col fw-bold text-dark mb-0">: <span
                                            class="ms-1 col fw-light text-second">{{ $transaksi->pelanggan->nama_pemilik }}
                                            / {{ $transaksi->pelanggan->nama_perusahaan }}</span>
                                    </p>
                                </div>
                                <div class="row">
                                    <p class="col-3 fw-bold text-dark mb-0">Email</p>
                                    <p class="col fw-bold text-dark mb-0">: <span
                                            class="ms-1 col fw-light text-second">{{ $transaksi->pelanggan->email }}</<
                                                /span>
                                    </p>
                                </div>
                                <div class="row">
                                    <p class="col-3 fw-bold text-dark mb-0">No Hp</p>
                                    <p class="col fw-bold text-dark mb-0">: <span
                                            class="ms-1 col fw-light text-second">{{ $transaksi->pelanggan->no_hp }}</span>
                                    </p>
                                </div>
                                <div class="row">
                                    <p class="col-3 fw-bold text-dark mb-0">Alamat</p>
                                    <p class="col fw-bold text-dark mb-0">: <span
                                            class="ms-1 col fw-light text-second">{{ $transaksi->pelanggan->alamat }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- Header Tabel --}}
                        <div class="row py-0">
                            {{-- Filter Tabel --}}
                            <div class="row col-6 p-0 m-0">
                                <div class="col-md-3">
                                    <label for="filterTanggalAwal" class="form-label">Tanggal Awal</label>
                                    <div class="input-group border rounded-2">
                                        <input type="date" id="filterTanggalAwal" class="form-control px-1">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="filterTanggalAkhir" class="form-label">Tanggal Akhir</label>
                                    <div class="input-group border rounded-2">
                                        <input type="date" id="filterTanggalAkhir" class="form-control px-1">
                                    </div>
                                </div>
                                <div class="col-md-2 align-self-end">
                                    <button id="applyFilter" class="btn btn-primary m-0 mt-2">Filter</button>
                                </div>
                            </div>
                            {{-- Export Tabel --}}
                            <div class="row col-6 p-0 m-0 justify-content-end">
                                <div class="col-md-2 align-self-end px-0 mx-0">
                                    <a id="exportExcel"
                                        href="{{ url('/pembelian/more/pesanan/' . $transaksi->id_transaksi . '/export_excel') }}"
                                        class="btn btn-icon btn-3 btn-primary m-0 mt-2" type="button">
                                        <span class="btn-inner--icon"><i class="fa-regular fa-file-excel"></i></span>
                                        <span class="btn-inner--text">Excel</span>
                                    </a>
                                </div>
                                <div class="col-md-2 align-self-end px-0 mx-0">
                                    <a id="exportPDF"
                                        href="{{ url('/pembelian/more/pesanan/' . $transaksi->id_transaksi . '/export_pdf') }}"
                                        class="btn btn-icon btn-3 btn-primary m-0 mt-2" type="button">
                                        <span class="btn-inner--icon"><i class="fa-regular fa-file-pdf"></i></span>
                                        <span class="btn-inner--text">PDF</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        {{-- Tabel --}}
                        <div class="table-responsive p-0" style="min-height:380px; overflow-y: auto;">
                            <table class="table align-items-center mb-0" id="table_pesanan">
                                <thead class="sticky-top bg-white z-index-1">
                                    <tr>
                                        <th rowspan="2"
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            No</th>
                                        <th rowspan="2"
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Resi</th>
                                        <th rowspan="2"
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Hari</th>
                                        <th rowspan="2"
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Tanggal</th>
                                        <th rowspan="2"
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Pelanggan</th>
                                        <th rowspan="2"
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            No. Pol</th>
                                        <th rowspan="2"
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Nota</th>
                                        <th colspan="4"
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Tekanan</th>
                                        <th rowspan="2"
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Volume<br>LWC/m<sup>3</sup></th>
                                        <th rowspan="2"
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">
                                            Total Harga</th>
                                        <th rowspan="2"></th>
                                    </tr>
                                    <tr>
                                        <th style="padding-inline: 2px;"
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Awal</th>
                                        <th style="padding-inline: 2px;"
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Akhir</th>
                                        <th style="padding-inline: 2px;"
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Selisih</th>
                                        <th style="padding-inline: 2px;"
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            LWC</th>
                                    </tr>
                                </thead>
                                <tbody id="table_pesanan_body">
                                </tbody>
                                <tfoot
                                    style="border-top: 1px solid #f0f2f5; position: sticky; bottom: 0; z-index: 10; background-color: #ffffff;">
                                    <tr>
                                        <td colspan="11"
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Jumlah</td>
                                        <td id="totalM3" class="text-center text-secondary text-sm font-weight-bolder">
                                            0</td>
                                        <td id="totalHarga" class="text-center text-secondary text-sm font-weight-bolder">
                                            0</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="text-center mt-5" id="noResultsMessage_pesanan" style="display: none;">
                                <p class="fw-light">Pesanan tidak ditemukan.</p>
                            </div>
                        </div>
                        {{-- Pesanan Awal --}}
                        {{-- <div class="row mx-2 mb-3">
                            <p class="col-3 fw-bold text-dark mb-0">Pesanan Awal</p>
                            <div class="table-responsive border rounded p-0" style="max-height: 450px; overflow-y: auto;">
                                <table class="table align-items-center mb-0" id="table_pembelian">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Waktu</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jumlah Transaksi</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Total Bayar</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status Pengiriman</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="fw-light">
                                            <td class="text-center">
                                                <p class="text-sm mb-0">tanggal :
                                                    {{ date('d/m/Y', strtotime($pesananAwal->tanggal_pesanan)) }}</p>
                                                <p class="text-sm mb-0">jam :
                                                    {{ date('H:i', strtotime($pesananAwal->tanggal_pesanan)) }}</p>
                                            </td>
                                            <td class="text-center">
                                                {{ $pesananAwal->jumlah_bar }} bar / {{ $pesananAwal->jumlah_m3 }} m<sup>3</sup>
                                            </td>
                                            <td class="text-center">
                                                Rp. {{ number_format($pesananAwal->harga_pesanan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                @foreach ($pengirimans as $pengiriman)
                                                    @if ($pesananAwal->id_pesanan == $pengiriman->id_pesanan)
                                                        @if ($pengiriman->status_pengiriman == 'Proses')
                                                            <span class="badge badge-sm bg-gradient-danger">Belum Dikirim</span>
                                                        @elseif ($pengiriman->status_pengiriman == 'Dikirim')
                                                            <span class="badge badge-sm bg-gradient-info">Dikirim</span>
                                                        @else
                                                            <a href="{{ url('/pembelian/more/pesanan/pengiriman/' . $pesananAwal->id_pesanan) }}" class="badge badge-sm bg-gradient-success text-white">Diterima</a>
                                                        @endif
                                                    @endif    
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> --}}
                        {{-- Pesanan Akhir --}}
                        {{-- <div class="row mx-2 mb-3">
                            <p class="col-3 fw-bold text-dark mb-0">Pesanan Akhir</p>
                            <div class="table-responsive border rounded p-0" style="max-height: 450px; overflow-y: auto;">
                                <table class="table align-items-center mb-0" id="table_pembelian">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Waktu</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jumlah Transaksi</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Total Bayar</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status Pengiriman</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="fw-light">
                                            <td class="text-center">
                                                <p class="text-sm mb-0">tanggal :
                                                    {{ date('d/m/Y', strtotime($pesananAkhir->tanggal_pesanan)) }}</p>
                                                <p class="text-sm mb-0">jam :
                                                    {{ date('H:i', strtotime($pesananAkhir->tanggal_pesanan)) }}</p>
                                            </td>
                                            <td class="text-center">
                                                {{ $pesananAkhir->jumlah_bar }} bar / {{ $pesananAkhir->jumlah_m3 }} m<sup>3</sup>
                                            </td>
                                            <td class="text-center">
                                                Rp. {{ number_format($pesananAkhir->harga_pesanan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                @foreach ($pengirimans as $pengiriman)
                                                    @if ($pesananAkhir->id_pesanan == $pengiriman->id_pesanan)
                                                        @if ($pengiriman->status_pengiriman == 'Proses')
                                                            <span class="badge badge-sm bg-gradient-danger">Belum Dikirim</span>
                                                        @elseif ($pengiriman->status_pengiriman == 'Dikirim')
                                                            <span class="badge badge-sm bg-gradient-info">Dikirim</span>
                                                        @else
                                                            <a href="{{ url('/pembelian/more/pesanan/pengiriman/' . $pesananAkhir->id_pesanan) }}" class="badge badge-sm bg-gradient-success text-white">Diterima</a>
                                                        @endif
                                                    @endif    
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> --}}
                        {{-- Semua Pesanan --}}
                        {{-- <div class="row mx-2 mb-3">
                            <p class="col-3 fw-bold text-dark mb-0">Semua Pesanan</p>
                            <div class="table-responsive border rounded p-0" style="max-height: 450px; overflow-y: auto;">
                                <table class="table align-items-center mb-0" id="table_pembelian">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nomor</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Waktu</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jumlah Transaksi</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Total Bayar</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status Pengiriman</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pesanans as $pesanan)
                                            <tr class="fw-light">
                                                <td class="text-center">{{ $loop->iteration }} </td>
                                                <td class="text-center">
                                                    <p class="text-sm mb-0">tanggal :
                                                        {{ date('d/m/Y', strtotime($pesanan->tanggal_pesanan)) }}</p>
                                                    <p class="text-sm mb-0">jam :
                                                        {{ date('H:i', strtotime($pesanan->tanggal_pesanan)) }}</p>
                                                </td>
                                                <td class="text-center">
                                                    {{ $pesanan->jumlah_bar }} bar / {{ $pesanan->jumlah_m3 }} m<sup>3</sup>
                                                </td>
                                                <td class="text-center">
                                                    Rp. {{ number_format($pesanan->harga_pesanan, 0, ',', '.') }}
                                                </td>
                                                <td class="text-center">
                                                    @foreach ($pengirimans as $pengiriman)
                                                        @if ($pesanan->id_pesanan == $pengiriman->id_pesanan)
                                                            @if ($pengiriman->status_pengiriman == 'Proses')
                                                                <span class="badge badge-sm bg-gradient-danger">Belum Dikirim</span>
                                                            @elseif ($pengiriman->status_pengiriman == 'Dikirim')
                                                                <span class="badge badge-sm bg-gradient-info">Dikirim</span>
                                                            @else
                                                                <a href="{{ url('/pembelian/more/pesanan/pengiriman/' . $pesanan->id_pesanan) }}" class="badge badge-sm bg-gradient-success text-white">Diterima</a>
                                                            @endif
                                                        @endif    
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="text-center" style="background-color: #e9ecef">
                                            <td class="fw-bold text-secondary">Total: </td>
                                            <td></td>
                                            <td colspan="3" class="fw-bold text-primary">Rp. {{ number_format($transaksi->tagihan->jumlah_tagihan, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Bukti Nota --}}
    @foreach ($pengirimans as $pengiriman)
        <div class="modal fade" id="modalBuktiNota{{ $pengiriman->id_pengiriman }}" tabindex="-1" role="dialog" aria-labelledby="modal-title-default"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-title-default">Bukti Nota</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-dark text-center" style="max-height:450px; overflow-y: auto;">
                        <!-- Mengecek jika bukti gas masuk tersedia -->
                        @if ($pengiriman->bukti_nota_sopir == null)
                            <div class="w-100 rounded" style="background-color: #dee2e6;">
                                <p class="text-white py-9">Belum ada bukti</p>
                            </div>
                        @else
                            <img src="{{ asset('img/NotaSopir/' . $pengiriman->bukti_nota_sopir) }}" class="w-100 rounded" alt="Bukti Nota">
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary shadow" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@section('js')
    <script>
        if ('{{ $transaksi->tagihan->status_tagihan === 'Sudah Bayar' }}') {
            clearInterval(x);
            document.getElementById('countdown').innerHTML =
                'Tagihan Sudah Dibayar !';
        } else {
            var tanggalJatuhTempo = new Date('{{ $transaksi->tagihan->tanggal_jatuh_tempo }}').getTime();
            var x = setInterval(function() {
                var sekarang = new Date().getTime();
                var selisih = tanggalJatuhTempo - sekarang;
                var hari = Math.floor(selisih / (1000 * 60 * 60 * 24));
                var jam = Math.floor((selisih % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var menit = Math.floor((selisih % (1000 * 60 * 60)) / (1000 * 60));
                var detik = Math.floor((selisih % (1000 * 60)) / 1000);
                document.getElementById('countdown').innerHTML = hari + 'd ' + jam + 'h ' + menit + 'm ' + detik +
                    's ';
                if (selisih < 0) {
                    clearInterval(x);
                    document.getElementById('countdown').innerHTML =
                        'Tagihan Sudah Jatuh Tempo!';
                }
            }, 1000);
        }
    </script>
    <script>
        function realtime_Pesanan() {
            var transaksi = @json($transaksi);
            var tanggalAwal = $('#filterTanggalAwal').val();
            var tanggalAkhir = $('#filterTanggalAkhir').val();
            $.ajax({
                url: `/pembelian/more/pesanan/${transaksi.id_transaksi}/data`,
                type: 'GET',
                dataType: 'json',
                data: {
                    tanggal_awal: tanggalAwal,
                    tanggal_akhir: tanggalAkhir
                },
                success: function(data) {
                    var table = $('#table_pesanan tbody');
                    table.empty();

                    if (!data.pesanans || data.pesanans.length === 0) {
                        var row =
                            '<tr class="text-dark">' +
                            '<td colspan="7" class="text-center fw-light text-secondary text-sm pt-5">Tidak ada pesanan.</td>' +
                            '</tr>';

                        table.append(row);
                    } else {
                        $.each(data.pesanans, function(index, pesanan) {
                            var datetimeString = pesanan.tanggal_pesanan;
                            var formatedDateTime = formatDateTime(datetimeString);
                            var mobilText = pesanan.pengiriman.mobil ? pesanan.pengiriman.mobil
                                .nopol_mobil : 'Belum Dikirim';
                            var gasMasuk = pesanan.pengiriman.kapasitas_gas_masuk ? pesanan.pengiriman
                                .kapasitas_gas_masuk : 0;
                            var gasKeluar = pesanan.pengiriman.kapasitas_gas_keluar ? pesanan.pengiriman
                                .kapasitas_gas_keluar : 0;
                            var lwc = pesanan.lwc ? pesanan.lwc : 0;
                            var sisaGas = pesanan.pengiriman.sisa_gas ? pesanan.pengiriman.sisa_gas : 0;
                            var m3 = pesanan.jumlah_m3 ? pesanan.jumlah_m3 : 0;
                            var hargaPesanan = pesanan.harga_pesanan;
                            var hargaFormatted = formatRupiah(hargaPesanan);
                            var row =
                                '<tr class="text-dark">' +
                                '<td class="text-center">' +
                                '<p class="text-sm mb-0">' + (index + 1) + '</p>' +
                                '</td>' +
                                '<td>' +
                                '<p class="text-xs font-weight-bold mb-0">' + pesanan.pengiriman
                                .kode_pengiriman + '</p>' +
                                '</td>' +
                                '<td class="text-center">' +
                                '<p class="text-sm mb-0">' + formatedDateTime.hari + '</p>' +
                                '</td>' +
                                '<td class="text-center">' +
                                '<p class="text-sm mb-0">' + formatedDateTime.tanggal + '</p>' +
                                '</td>' +
                                '<td class="text-center">' +
                                '<p class="text-sm mb-0">' + pesanan.transaksi.pelanggan
                                .nama_perusahaan + '</p>' +
                                '</td>' +
                                '<td class="text-center">' +
                                '<a href="#" type="button" data-bs-toggle="modal" data-bs-target="#modalBuktiNota' +
                                pesanan.pengiriman.id_pengiriman +
                                '" class="text-sm fw-light mb-0 opacity-7"><u/>Bukti Nota</u></a>' +
                                '</td>' +
                                '<td class="text-center">' +
                                '<p class="text-sm mb-0">' + mobilText + '</p>' +
                                '</td>' +
                                '<td class="text-center">' +
                                '<p class="text-sm mb-0">' + gasMasuk + '</p>' +
                                '</td>' +
                                '<td class="text-center">' +
                                '<p class="text-sm mb-0">' + sisaGas + '</p>' +
                                '</td>' +
                                '<td class="text-center">' +
                                '<p class="text-sm mb-0">' + gasKeluar + '</p>' +
                                '</td>' +
                                '<td class="text-center">' +
                                '<p class="text-sm mb-0">' + lwc + '</p>' +
                                '</td>' +
                                '<td class="text-center">' +
                                '<p class="text-sm mb-0">' + m3 + '</p>' +
                                '</td>' +
                                '<td class="text-center">' +
                                '<p class="text-sm mb-0">' + hargaFormatted + '</p>' +
                                '</td>' +
                                '<td class="text-center">' +
                                '<a href="{{ url('/pembelian/more/pesanan/pengiriman/') }}/' + pesanan
                                .id_pesanan +
                                '" class="text-sm mb-0" title="Edit"><i class="fa fa-solid fa-pen" style="color: #252f40;"></i></a>' +
                                '</td>' +
                                '</tr>';
                            table.append(row);
                        });

                        $('#totalHarga').text(formatRupiah(data.totalharga));
                        $('#totalM3').text(parseFloat(data.totalm3).toFixed(2));
                    }
                    table.show();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function formatDateTime(datetimeString) {
            var datetime = new Date(datetimeString);
            // Array hari dan bulan dalam bahasa Indonesia
            var hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            // Fungsi untuk menambahkan nol jika nilai kurang dari 10
            function padZero(num) {
                return num < 10 ? '0' + num : num;
            }
            // Mendapatkan nama hari, tanggal, bulan, dan tahun
            var namaHari = hari[datetime.getDay()];
            var tanggal = padZero(datetime.getDate()); // Tambahkan nol jika tanggal kurang dari 10
            var namaBulan = bulan[datetime.getMonth()];
            var tahun = datetime.getFullYear();
            // Mendapatkan jam, menit, dan detik
            var jam = padZero(datetime.getHours()) + ':' + padZero(datetime.getMinutes()) + ':' + padZero(datetime
                .getSeconds());
            // Format tanggal seperti yang diminta: "2-Sep-2024"
            var formatTanggal = tanggal + '-' + namaBulan + '-' + tahun;
            return {
                tanggal: formatTanggal, // Format: 2-Sep-2024
                hari: namaHari, // Format hari dalam bahasa Indonesia: Senin, Selasa, dll.
                jam: jam // Format waktu: 14:05:07
            };
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                currencyDisplay: 'symbol',
                minimumFractionDigits: 0 // Menghilangkan desimal jika tidak diperlukan
            }).format(angka);
        }

        // Trigger the filter on button click
        $('#applyFilter').on('click', function() {
            realtime_Pesanan();
        });

        $(document).ready(function() {
            realtime_Pesanan();
        });


        document.addEventListener("DOMContentLoaded", function(event) {
            Echo.channel(`PesananBaru-channel`).listen('PesananBaruEvent', (e) => {
                realtime_Pesanan();
            });
            Echo.channel(`GasMasuk-channel`).listen('GasMasukEvent', (e) => {
                realtime_Pesanan();
            });
            Echo.channel(`GasKeluar-channel`).listen('GasKeluarEvent', (e) => {
                realtime_Pesanan();
            });
        });
    </script>
    {{-- Export Excel Tanggal --}}
    <script>
        document.getElementById('applyFilter').addEventListener('click', function() {
            // Mengambil tanggal awal dan akhir
            const tanggalAwal = document.getElementById('filterTanggalAwal').value;
            const tanggalAkhir = document.getElementById('filterTanggalAkhir').value;

            // Mengatur URL untuk ekspor Excel dengan parameter tanggal
            const exportButton = document.getElementById('exportExcel');
            const baseUrl = '{{ url('/pembelian/more/pesanan/' . $transaksi->id_transaksi . '/export_excel') }}';

            // Menambahkan parameter tanggal ke URL
            exportButton.href = `${baseUrl}?tanggal_awal=${tanggalAwal}&tanggal_akhir=${tanggalAkhir}`;
        });
    </script>
    {{-- Export PDF Tanggal --}}
    <script>
        document.getElementById('applyFilter').addEventListener('click', function() {
            // Mengambil tanggal awal dan akhir
            const tanggalAwal = document.getElementById('filterTanggalAwal').value;
            const tanggalAkhir = document.getElementById('filterTanggalAkhir').value;

            // Mengatur URL untuk ekspor Excel dengan parameter tanggal
            const exportButton = document.getElementById('exportPDF');
            const baseUrl = '{{ url('/pembelian/more/pesanan/' . $transaksi->id_transaksi . '/export_pdf') }}';

            // Menambahkan parameter tanggal ke URL
            exportButton.href = `${baseUrl}?tanggal_awal=${tanggalAwal}&tanggal_akhir=${tanggalAkhir}`;
        });
    </script>
@endsection
