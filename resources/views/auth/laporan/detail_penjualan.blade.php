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
                    <a class="nav-link text-white active bg-gradient-primary" href="{{ url('/laporan/detail_penjualan') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Detail Penjualan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark " href="{{ url('/laporan/omzet_penjualan') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Omzet Penjualan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark " href="{{ url('/laporan/laporan_bop') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Laporan BOP</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark " href="{{ url('/laporan/modal_tambahan') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Modal Tambahan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark " href="{{ url('/laporan/kas_keluar') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Kas Keluar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark " href="{{ url('/laporan/laba_rugi') }}">
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
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail Penjualan</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Detail Penjualan</h6>
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
                            <h4 class="card-title">Detail Penjualan</h4>
                        </div>
                    </div>
                    <div class="row justify-content-between mb-3">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="d-flex align-items-center text-dark mb-3">
                                    <span class="text-sm me-2">Menampilkan </span>
                                    <form action="{{ url('laporan/detail_penjualan') }}" method="get"
                                        class="form-inline me-2">
                                        <input type="hidden" name="tanggal_awal"
                                            value="{{ request('tanggal_awal', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                                        <input type="hidden" name="tanggal_akhir"
                                            value="{{ request('tanggal_akhir', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                                        <select name="perPage_data" id="perPage_data"
                                            class="form-control border rounded px-2" onchange="this.form.submit()">
                                            <option value="10" {{ $perPage_data == 10 ? 'selected' : '' }}>10</option>
                                            <option value="50" {{ $perPage_data == 50 ? 'selected' : '' }}>50</option>
                                            <option value="100" {{ $perPage_data == 100 ? 'selected' : '' }}>100
                                            </option>
                                            <option value="{{ $data_table->total() }}"
                                                {{ $perPage_data == $data_table->total() ? 'selected' : '' }}>Semua
                                            </option>
                                        </select>
                                    </form>
                                    <span class="text-sm">data</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <form method="GET" action="{{ url('/laporan/detail_penjualan') }}" class="row">
                                    @csrf
                                    <input type="hidden" name="perPage_data" value="{{ $perPage_data }}">
                                    <div class="col-md-4">
                                        <label for="filterTanggalAwal" class="form-label">Tanggal Awal</label>
                                        <div class="input-group border rounded-2">
                                            <input type="date" id="filterTanggalAwal" name="tanggal_awal"
                                                class="form-control px-1"
                                                value="{{ request('tanggal_awal', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="filterTanggalAkhir" class="form-label">Tanggal Akhir</label>
                                        <div class="input-group border rounded-2">
                                            <input type="date" id="filterTanggalAkhir" name="tanggal_akhir"
                                                class="form-control px-1"
                                                value="{{ request('tanggal_akhir', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 p-0 d-flex align-items-end">
                                        <div class="px-2 mt-2">
                                            <button type="submit" class="btn btn-primary m-0"
                                                style="padding-left: 37px; padding-right: 37px;">Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row px-2">
                                <div class="input-group mb-3 border rounded-2">
                                    <span class="input-group-text text-body me-2"><i class="fa fa-search"
                                            aria-hidden="true"></i></span>
                                    <input type="text" class="form-control ms-2" id="searchInput_Data"
                                        placeholder="Cari  ...">
                                </div>
                            </div>
                            <div class="row px-2">
                                <div class="col-12 p-0 m-0 d-flex justify-content-between align-items-center mt-4">
                                    <!-- Export Excel Form -->
                                    <form method="GET" action="{{ url('/laporan/detail_penjualan/export_excel') }}">
                                        @csrf
                                        <input type="hidden" name="tanggal_awal" id="excelTanggalAwal" value="{{ request('tanggal_awal', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                                        <input type="hidden" name="tanggal_akhir" id="excelTanggalAkhir" value="{{ request('tanggal_akhir', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                                        <button type="submit" class="btn btn-icon btn-3 btn-primary m-0" style="padding-left: 43px; padding-right: 43px;">
                                            <span class="btn-inner--icon"><i class="fa-regular fa-file-excel"></i></span>
                                            <span class="btn-inner--text">Excel</span>
                                        </button>
                                    </form>
                                
                                    <!-- Export PDF Form -->
                                    <form method="GET" action="{{ url('/laporan/detail_penjualan/export_pdf') }}" target="_blank">
                                        @csrf
                                        <input type="hidden" name="tanggal_awal" id="pdfTanggalAwal" value="{{ request('tanggal_awal', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                                        <input type="hidden" name="tanggal_akhir" id="pdfTanggalAkhir" value="{{ request('tanggal_akhir', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                                        <button type="submit" class="btn btn-icon btn-3 btn-primary m-0" style="padding-left: 43px; padding-right: 43px;">
                                            <span class="btn-inner--icon"><i class="fa-regular fa-file-pdf"></i></span>
                                            <span class="btn-inner--text">PDF</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-3 pt-0 pb-2" style="min-height: 430px;">
                    <div class="table-responsive p-0" style="min-height:380px; overflow-y: auto;">
                        <table class="table align-items-center mb-0" id="table_Data">
                            <thead class="sticky-top bg-white z-index-1">
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Resi</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Tanggal Pesanan</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Pelanggan</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Tujuan</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Jumlah Pesanan</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Harga</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Waktu<br>Payment</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Payment<br>Methode</th>
                                </tr>
                            </thead>
                            <tbody id="table_Data_body" class="text-dark">
                                @forelse($data_table as $pesanan)
                                    <tr>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $pesanan->transaksi->resi_transaksi }}</p>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                // Mengonversi tanggal ke format yang diinginkan
                                                $tanggalPesanan = \Carbon\Carbon::parse($pesanan->tanggal_pesanan);
                                                $formattedDate = $tanggalPesanan->translatedFormat('d-M-Y'); // Format: Hari, tanggal-bulan-tahun
                                                $formattedTime = $tanggalPesanan->format('H:i'); // Format: Jam
                                            @endphp
                                            <p class="text-sm font-weight-light mb-0">{{ $formattedDate }}</p>
                                            <p class="text-sm font-weight-light mb-0">Jam : {{ $formattedTime }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-light mb-0">
                                                {{ $pesanan->transaksi->pelanggan->nama_perusahaan }}</p>
                                        </td>
                                        <td class="text-wrap">
                                            <p class="text-sm font-weight-light mb-0">
                                                {{ $pesanan->transaksi->pelanggan->alamat }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-light mb-0">{{ $pesanan->jumlah_bar }} bar</p>
                                            <p class="text-sm font-weight-light mb-0">{{ $pesanan->jumlah_m3 }}
                                                m<sup>3</sup></p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-light mb-0"> Rp.
                                                {{ number_format($pesanan->harga_pesanan, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="text-center">
                                            @if (
                                                $pesanan->transaksi->tagihan->status_tagihan === 'Sudah Bayar' ||
                                                    $pesanan->transaksi->tagihan->status_tagihan === 'Diproses')
                                                <p class="text-sm font-weight-light mb-0">
                                                    {{ date('d/M/Y', strtotime($pesanan->transaksi->tagihan->tanggal_pembayaran)) }}
                                                </p>
                                                <p class="text-sm font-weight-light mb-0">
                                                    Jam :
                                                    {{ date('H:i', strtotime($pesanan->transaksi->tagihan->tanggal_pembayaran)) }}
                                                </p>
                                            @else
                                                <p class="text-sm font-weight-light text-danger mb-0">Belum Bayar</p>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if (
                                                $pesanan->transaksi->tagihan->status_tagihan === 'Sudah Bayar' ||
                                                    $pesanan->transaksi->tagihan->status_tagihan === 'Diproses')
                                                <p class="text-sm font-weight-light mb-0">Tunai</p>
                                            @else
                                                <p class="text-sm font-weight-light text-danger mb-0">Belum Bayar</p>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <p class="fw-light text-sm mt-5">Tidak ada pesanan hari ini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="text-center mt-5" id="noResultsMessage_Data" style="display: none;">
                            <p class="fw-light text-sm mt-5">Pesanan tidak ditemukan.</p>
                        </div>
                    </div>

                    {{-- Pagination --}}
                    <div class="pt-4 d-flex">
                        <div class="col">
                            <p class="text-sm">Menampilkan {{ $data_table->firstItem() }} hingga
                                {{ $data_table->lastItem() }} dari total {{ $data_table->total() }} data</p>
                        </div>
                        <div class="col">
                            <ul class="pagination pagination-primary justify-content-end">
                                @if ($data_table->onFirstPage())
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span class="material-icons">keyboard_arrow_left</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $data_table->appends(request()->all())->previousPageUrl() }}"
                                            aria-label="Previous">
                                            <span class="material-icons">keyboard_arrow_left</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                @endif

                                {{-- Display range of pages dynamically --}}
                                @for ($page = 1; $page <= $data_table->lastPage(); $page++)
                                    @if ($page >= $data_table->currentPage() - 2 && $page <= $data_table->currentPage() + 2)
                                        <li class="page-item {{ $page == $data_table->currentPage() ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $data_table->appends(request()->all())->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endfor

                                @if ($data_table->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $data_table->appends(request()->all())->nextPageUrl() }}"
                                            aria-label="Next">
                                            <span class="material-icons">keyboard_arrow_right</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span class="material-icons">keyboard_arrow_right</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#searchInput_Data").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table_Data_body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });

                var noResultsMessage = $("#noResultsMessage_Data");
                if ($("#table_Data_body tr:visible").length === 0) {
                    noResultsMessage.show();
                } else {
                    noResultsMessage.hide();
                }
            });
        });
    </script>
    <script>
        document.getElementById('perPage_data').addEventListener('change', function () {
            document.getElementById('filterForm').elements['perPage_data'].value = this.value;
            document.getElementById('perPageForm').submit();
        });
    </script>
    <script>
        document.getElementById('filterTanggalAwal').addEventListener('change', function () {
            document.getElementById('excelTanggalAwal').value = this.value;
            document.getElementById('pdfTanggalAwal').value = this.value;
        });
    
        document.getElementById('filterTanggalAkhir').addEventListener('change', function () {
            document.getElementById('excelTanggalAkhir').value = this.value;
            document.getElementById('pdfTanggalAkhir').value = this.value;
        });
    </script>
@endsection
