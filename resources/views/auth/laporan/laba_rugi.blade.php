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
                    <a class="nav-link text-dark" href="{{ url('/pembelian') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">shopping_cart</i>
                        </div>
                        <span class="nav-link-text ms-1">Pembelian</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('/pengiriman') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-solid fa-dolly" style="color: #344767;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Pengiriman</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8">Laporan
                    </h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('/laporan/detail_penjualan') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Detail Penjualan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('/laporan/omzet_penjualan') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Omzet Penjualan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('/laporan/laporan_bop') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Laporan BOP</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('/laporan/modal_tambahan') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Modal Tambahan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('/laporan/kas_keluar') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Kas Keluar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white active bg-gradient-primary" href="{{ url('/laporan/laba_rugi') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Laba Rugi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark " href="{{ url('/laporan/buku_besar') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Buku Besar</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8">Sopir dan BOP
                    </h6>
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
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Laba Rugi</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Laba Rugi</h6>
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
    <div class="row">
        {{-- Tabel --}}
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row mb-3">
                        <div class="col d-flex align-items-center">
                            <h4 class="card-title">Laba Rugi</h4>
                        </div>
                    </div>
                    <div class="row justify-content-between mb-3">
                        <div class="col-md-12 justify-content-between">
                            <div class="row mb-3">
                                <div class="row col-md-12 pe-0 d-flex justify-content-between align-items-center">
                                    <form  class="col-md-3" method="GET" action="{{ url('/laporan/laba_rugi') }}" id="formLaporan">
                                        @csrf
                                        <div>
                                            <label for="tanggal" class="form-label">Tanggal</label>
                                            <div class="input-group border rounded-2">
                                                <input type="date" id="tanggal" name="tanggal"
                                                    class="form-control px-1"
                                                    value="{{ request('tanggal', \Carbon\Carbon::today()->format('Y-m-d')) }}"
                                                    onchange="this.form.submit()">
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Tombol Export -->
                                    <div class="col-md-3 mt-4 d-flex justify-content-end align-items-center">
                                        <!-- Export Excel Form -->
                                        <form method="GET" action="{{ url('/laporan/laba_rugi/export_excel') }}">
                                            @csrf
                                            <input type="hidden" name="tanggal" id="excelTanggal"
                                                value="{{ request('tanggal', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                                            <button type="submit" class="btn btn-icon btn-3 btn-primary m-0"
                                                style="padding-left: 43px; padding-right: 43px;">
                                                <span class="btn-inner--icon"><i
                                                        class="fa-regular fa-file-excel"></i></span>
                                                <span class="btn-inner--text">Excel</span>
                                            </button>
                                        </form>

                                        <!-- Export PDF Form -->
                                        <form class="ms-2" method="GET"
                                            action="{{ url('/laporan/laba_rugi/export_pdf') }}" target="_blank">
                                            @csrf
                                            <input type="hidden" name="tanggal" id="pdfTanggal"
                                                value="{{ request('tanggal', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                                            <button type="submit" class="btn btn-icon btn-3 btn-primary m-0"
                                                style="padding-left: 43px; padding-right: 43px;">
                                                <span class="btn-inner--icon"><i
                                                        class="fa-regular fa-file-pdf"></i></span>
                                                <span class="btn-inner--text">PDF</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pt-0 pb-2 mb-5">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="table_Data" style="border: 1px solid #ddd;">
                            <tbody id="table_Data_body" class="text-dark">
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
                                <tr class="bg-primary" style="border-bottom: 1px solid #ddd;">
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
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        // Menambahkan event listener untuk form submission otomatis saat tanggal berubah
        document.getElementById('tanggal').addEventListener('change', function() {
            document.getElementById('formLaporan').submit();
        });
    </script>
    <script>
        document.getElementById('tanggal').addEventListener('change', function() {
            document.getElementById('excelTanggal').value = this.value;
            document.getElementById('pdfTanggal').value = this.value;
        });
    </script>
@endsection
