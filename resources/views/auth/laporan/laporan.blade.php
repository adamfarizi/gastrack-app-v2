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
                <li class="nav-item">
                    <a class="nav-link text-white active bg-gradient-primary" href="{{ url('/laporan') }}">
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
                <li class="nav-item">
                    <a class="nav-link text-dark " href="{{ url('/pengguna') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">group</i>
                        </div>
                        <span class="nav-link-text ms-1">Pengguna</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8">Halaman Pengguna
                    </h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('/profil/'.Auth::user()->id_admin) }}">
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
                <a class="btn bg-gradient-primary w-100"
                    href="{{ url('logout') }}"
                    type="button">Keluar</a>
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
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Laporan</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Laporan</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <ul class="navbar-nav justify-content-end me-5">
                        <div class="d-flex py-1">
                            <div class="my-auto">
                                <img src="{{ asset('../assets/img/local/profil.png') }}" class="border-radius-lg avatar-sm me-3 mt-1">
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                    <span class="font-weight-bold">  {{ Auth::user()->nama }}  </span>
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
        {{-- Tabel Detail Pesanan --}}
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col d-flex align-items-center">
                            <h4 class="card-title">Detail Penjualan</h4>
                            <span class="mt-1 ms-3">
                              <button id="exportDetailPenjualan" class="btn btn-primary btn-sm shadow-none me-2">Export</button>
                            </span>
                        </div>
                        <div class="col-md-2 col-sm-6 ml-auto">
                            <div class="input-group mb-3 border rounded-2">
                                <span class="input-group-text text-body me-2"><i class="fa fa-search"
                                        aria-hidden="true"></i></span>
                                <input type="text" class="form-control ms-2" id="searchInput_detailPenjualan"
                                    placeholder="Cari  ...">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 ml-auto">
                            <div class="input-group mb-3 border rounded-2">
                                <input type="date" class="form-control ms-2 me-2" id="dateFilter" 
                                onchange="filterTableByDate('table_detailPenjualan', 'dateFilter', 'noResultsMessage_detailPenjualan')">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-3 pt-0 pb-5" style="min-height: 428px;">
                    <div class="table-responsive p-0" style="max-height: 450px; overflow-y: auto;">
                        <table class="table align-items-center mb-0" id="table_detailPenjualan">
                            <thead class="sticky-top bg-white z-index-1">
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Resi</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nama Agen</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tujuan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Jumlah Pesanan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Harga</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Waktu Payment</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Payment Methode</th>
                                </tr>
                            </thead>
                            <tbody id="table_detailPenjualan_body" class="text-dark">
                                @foreach($transaksis as $transaksi)
                                    @foreach($transaksi->pesanan as $pesanan)
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-bold mb-0">{{ $transaksi->resi_transaksi }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-light mb-0">{{ $pesanan->tanggal_pesanan }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-light mb-0">{{ $transaksi->pelanggan->nama_perusahaan }}</p>
                                            </td>
                                            <td class="text-wrap">
                                                <p class="text-sm font-weight-light mb-0">{{ $transaksi->pelanggan->alamat }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-light mb-0">{{ $pesanan->jumlah_bar }} bar</p>
                                                <p class="text-sm font-weight-light mb-0">{{ $pesanan->jumlah_m3 }} m3</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-light mb-0"> Rp. {{ number_format($pesanan->harga_pesanan, 0, ',', '.') }}</p>
                                            </td>
                                            <td class="text-center">
                                                @if ($transaksi->tagihan->status_tagihan === 'Sudah Bayar' || $transaksi->tagihan->status_tagihan === 'Diproses')
                                                    <p class="text-sm font-weight-light mb-0">{{ date('d/m/Y', strtotime($transaksi->tagihan->tanggal_pembayaran)) }}</p>
                                                    <p class="text-sm font-weight-light mb-0">{{ date('H:i:s', strtotime($transaksi->tagihan->tanggal_pembayaran)) }}</p>
                                                @else
                                                    <p class="text-sm font-weight-light text-danger mb-0">Belum Bayar</p>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($transaksi->tagihan->status_tagihan === 'Sudah Bayar' || $transaksi->tagihan->status_tagihan === 'Diproses')
                                                    <p class="text-sm font-weight-light mb-0">Tunai</p>
                                                @else
                                                    <p class="text-sm font-weight-light text-danger mb-0">Belum Bayar</p>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>                                                                                                                                                                  
                        </table>
                        <div class="text-center mt-5" id="noResultsMessage_detailPenjualan" style="display: none;">
                            <p class="fw-light">Pesanan tidak ditemukan.</p>
                        </div>                     
                    </div>
                </div>
            </div>
        </div>
        {{-- Tabel Laporan Omzet --}}
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col d-flex align-items-center">
                            <h4 class="card-title">Laporan Omzet</h4>
                            <span class="mt-1 ms-3">
                              <button id="exportLaporanOmzet" class="btn btn-primary btn-sm shadow-none me-2">Export</button>
                            </span>
                        </div>
                        <div class="col-md-2 col-sm-6 ml-auto">
                            <div class="input-group mb-3 border rounded-2">
                                <span class="input-group-text text-body me-2"><i class="fas fa-search"
                                        aria-hidden="true"></i></span>
                                <input type="text" class="form-control ms-2" id="searchInput_laporanOmzet"
                                    placeholder="Cari  ...">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 ml-auto">
                            <div class="input-group mb-3 border rounded-2">
                                <input type="date" class="form-control ms-2 me-2" id="dateFilterOmzet" 
                                onchange="filterTableByDate('table_laporanOmzet', 'dateFilterOmzet', 'noResultsMessage_laporanOmzet')">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-3 pt-0 pb-2" style="min-height: 428px;">
                    <div class="table-responsive p-0" style="max-height: 450px; overflow-y: auto;">
                        <table class="table align-items-center mb-0" id="table_laporanOmzet">
                            <thead class="sticky-top bg-white z-index-1">
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Resi</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nama Agen</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tujuan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Jumlah Bar</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Jumlah M3</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Omzet</th>
                                </tr>
                            </thead>
                            <tbody id="table_laporanOmzet_body" class="text-dark">
                                @foreach($transaksis as $transaksi)
                                    @foreach($transaksi->pesanan as $pesanan)
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-bold mb-0">{{ $transaksi->resi_transaksi }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-light mb-0">{{ $pesanan->tanggal_pesanan }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-light mb-0">{{ $transaksi->pelanggan->nama_perusahaan }}</p>
                                            </td>
                                            <td class="text-wrap">
                                                <p class="text-sm font-weight-light mb-0">{{ $transaksi->pelanggan->alamat }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-light mb-0">{{ $pesanan->jumlah_bar }} bar</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-light mb-0">{{ $pesanan->jumlah_m3 }} m3</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-light mb-0"> Rp. {{ number_format($pesanan->harga_pesanan, 0, ',', '.') }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center mt-5" id="noResultsMessage_laporanOmzet" style="display: none;">
                            <p class="fw-light">Pesanan tidak ditemukan.</p>
                        </div>
                    </div>
                </div>
                <div class="px-3">
                    <hr class="mb-0">
                </div>
                <div class="card-footer d-flex">
                    <div class="col">
                        <p class="ms-5 text-xs text-uppercase fw-bold text-secondary">Total :</p>
                    </div>
                    <div class="col">
                        <p class="text-sm text-end fw-bold text-primary">Rp. {{ number_format($total_omzet, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
        {{-- Tabel Laporan BOP --}}
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col d-flex align-items-center">
                            <h4 class="card-title">Laporan BOP</h4>
                            <span class="mt-1 ms-3">
                              <button id="exportLaporanBOP" class="btn btn-primary btn-sm shadow-none me-2">Export</button>
                            </span>
                        </div>
                        <div class="col-md-2 col-sm-6 ml-auto">
                            <div class="input-group mb-3 border rounded-2">
                                <span class="input-group-text text-body me-2"><i class="fas fa-search"
                                        aria-hidden="true"></i></span>
                                <input type="text" class="form-control ms-2" id="searchInput_laporanBOP"
                                    placeholder="Cari  ...">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 ml-auto">
                            <div class="input-group mb-3 border rounded-2">
                                <input type="date" class="form-control ms-2 me-2" id="dateFilterBOP" 
                                onchange="filterTableByDate('table_laporanBOP', 'dateFilterBOP', 'noResultsMessage_laporanBOP')">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-3 pt-0 pb-5" style="min-height: 428px;">
                    <div class="table-responsive p-0" style="max-height: 450px; overflow-y: auto;">
                        <table class="table align-items-center mb-0" id="table_laporanBOP">
                            <thead class="sticky-top bg-white z-index-1">
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Resi Pengiriman</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tanggal Pengiriman</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nama Agen</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tujuan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Sopir</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Mobil</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">BOP</th>
                                </tr>
                            </thead>
                            <tbody id="table_laporanBOP_body" class="text-dark">
                                @foreach($pengirimans as $pengiriman)
                                    <tr>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-bold mb-0">{{ $pengiriman->kode_pengiriman }}</p>
                                        </td>
                                        <td class="text-center">
                                            @if ( $pengiriman->waktu_pengiriman == null)
                                            <p class="text-sm font-weight-light text-danger mb-0">Pesanan belum dikirim</p>
                                            @else
                                            <p class="text-sm font-weight-light mb-0">{{ $pengiriman->waktu_pengiriman }}</p>
                                            @endif
                                        </td>
                                        @php
                                            $pelangganNama = '';
                                            $pelangganAlamat = '';
                                            $pesananBelumDikirim = false;
                                        @endphp
                                        @foreach ($pesanans as $pesanan)
                                            @if ($pesanan->id_pesanan == $pengiriman->pesanan->id_pesanan)
                                                @php
                                                    $pelangganNama = $pesanan->transaksi->pelanggan->nama_perusahaan;
                                                    $pelangganAlamat = $pesanan->transaksi->pelanggan->alamat;
                                                @endphp
                                            @endif
                                        @endforeach
                                        <td class="text-center">
                                            <p class="text-sm font-weight-light mb-0">{{ $pelangganNama }}</p>
                                        </td>
                                        <td class="text-wrap">
                                            <p class="text-sm font-weight-light mb-0">{{ $pelangganAlamat }}</p>
                                        </td>
                                        <td class="text-center">
                                            @if ($pengiriman->sopir)
                                                <p class="text-sm font-weight-light mb-0">
                                                    {{ $pengiriman->sopir->nama }}
                                                </p>
                                                @else
                                                <p class="text-sm text-danger font-weight-light mb-0">
                                                    Pesanan belum dikirim
                                                </p>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($pengiriman->mobil)
                                                <p class="text-sm font-weight-light mb-0">
                                                    {{ $pengiriman->mobil->nopol_mobil }}
                                                </p>
                                                @else
                                                <p class="text-sm text-danger font-weight-light mb-0">
                                                    Pesanan belum dikirim
                                                </p>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-light mb-0">
                                                Rp. {{ number_format($pengiriman->pesanan->bop_pesanan, 0, ',', '.') }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center mt-5" id="noResultsMessage_laporanBOP" style="display: none;">
                            <p class="fw-light">Pesanan tidak ditemukan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setDefaultDate(elementId) {
            document.getElementById(elementId).valueAsDate = new Date();
        }
    
        // Panggil fungsi untuk mengatur tanggal default
        setDefaultDate('dateFilter');
        setDefaultDate('dateFilterOmzet');
        setDefaultDate('dateFilterBOP');
    </script>
    
    {{-- Filter by Tanggal --}}
    <script>
        function filterTableByDate(tableId, dateFilterId, noResultsMessageId) {
            // Ambil nilai tanggal dari input
            var selectedDate = document.getElementById(dateFilterId).value;
    
            // Saring data sesuai dengan tanggal yang dipilih
            $("#" + tableId + "_body tr").filter(function() {
                // Ambil tanggal dari setiap baris
                var rowDate = $(this).find("td:eq(1)").text(); // Gantilah indeks dengan indeks kolom yang berisi tanggal
    
                // Periksa apakah tanggal pada baris cocok dengan tanggal yang dipilih
                $(this).toggle(rowDate.includes(selectedDate));
            });
    
            // Sembunyikan atau tampilkan pesan jika tidak ada hasil
            var noResultsMessage = $("#" + noResultsMessageId);
            if ($("#" + tableId + "_body tr:visible").length === 0) {
                noResultsMessage.show();
            } else {
                noResultsMessage.hide();
            }
        }
    </script>    

    {{-- Search --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#searchInput_detailPenjualan").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table_detailPenjualan_body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });

                var noResultsMessage = $("#noResultsMessage_detailPenjualan");
                if ($("#table_detailPenjualan_body tr:visible").length === 0) {
                    noResultsMessage.show();
                } else {
                    noResultsMessage.hide();
                }
            });

            $("#searchInput_laporanOmzet").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table_laporanOmzet_body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });

                var noResultsMessage = $("#noResultsMessage_laporanOmzet");
                if ($("#table_laporanOmzet_body tr:visible").length === 0) {
                    noResultsMessage.show();
                } else {
                    noResultsMessage.hide();
                }
            });

            $("#searchInput_laporanBOP").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table_laporanBOP_body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });

                var noResultsMessage = $("#noResultsMessage_laporanBOP");
                if ($("#table_laporanBOP_body tr:visible").length === 0) {
                    noResultsMessage.show();
                } else {
                    noResultsMessage.hide();
                }
            });
        });
    </script>

    {{-- Export Excel --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fungsi untuk menangani ekspor Excel
            function exportToExcel(exportButtonId, tableId, fileName) {
                const exportButton = document.getElementById(exportButtonId);
                const table = document.getElementById(tableId);
    
                if (!table) {
                    console.error(`Table with ID '${tableId}' not found.`);
                    return;
                }
    
                exportButton.addEventListener('click', function () {
                    // Mengonversi seluruh tabel menjadi objek lembar kerja
                    const ws = XLSX.utils.table_to_sheet(table);
    
                    // Membuat buku kerja baru
                    const wb = XLSX.utils.book_new();
    
                    // Menambahkan lembar kerja ke buku kerja
                    XLSX.utils.book_append_sheet(wb, ws, 'Data');
    
                    // Menyimpan file Excel
                    XLSX.writeFile(wb, fileName);
                });
            }
    
            // Memanggil fungsi untuk setiap tombol "Export" dengan parameter yang sesuai
            exportToExcel('exportDetailPenjualan', 'table_detailPenjualan', 'detail_penjualan.xlsx');
            exportToExcel('exportLaporanOmzet', 'table_laporanOmzet', 'laporan_omzet.xlsx');
            exportToExcel('exportLaporanBOP', 'table_laporanBOP', 'laporan_BOP.xlsx');
        });
    </script>
    
    
@endsection