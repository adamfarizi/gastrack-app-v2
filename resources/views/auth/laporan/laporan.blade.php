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
                                <button id="exportLaporanBOP" class="btn btn-primary btn-sm shadow-none me-2" data-bs-toggle="modal" data-bs-target="#exportModalDetail">Export</button>
                            </span>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col d-flex align-items-center text-dark">
                            <span class="text-sm me-2">Menampilkan </span>
                            <form action="{{ route('Laporan') }}" method="get" class="form-inline me-2">
                                <select name="perPage_penjualan" id="perPage_penjualan" class="form-control border rounded px-2" onchange="this.form.submit()">
                                    <option value="10" {{ $perPage_penjualan == 10 ? 'selected' : '' }}>10</option>
                                    <option value="50" {{ $perPage_penjualan == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $perPage_penjualan == 100 ? 'selected' : '' }}>100</option>
                                    <option value="{{ $detail_penjualans->total() }}" {{ $perPage_penjualan == $detail_penjualans->total() ? 'selected' : '' }}>Semua</option>
                                </select>
                            </form>
                            <span class="text-sm">data</span>
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
                <div class="card-body px-3 pt-0 pb-2" style="min-height: 430px;">
                    <div class="table-responsive p-0" style="min-height:380px; max-height: 380px; overflow-y: auto;">
                        <table class="table align-items-center mb-0" id="table_detailPenjualan">
                            <thead class="sticky-top bg-white z-index-1">
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Resi</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Pelanggan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tujuan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Jumlah Pesanan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Harga</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Waktu Payment</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Payment Methode</th>
                                </tr>
                            </thead>
                            <tbody id="table_detailPenjualan_body" class="text-dark">
                                @forelse($detail_penjualans as $pesanan)
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-bold mb-0">{{ $pesanan->transaksi->resi_transaksi }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-light mb-0">{{ $pesanan->tanggal_pesanan }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-light mb-0">{{ $pesanan->transaksi->pelanggan->nama_perusahaan }}</p>
                                            </td>
                                            <td class="text-wrap">
                                                <p class="text-sm font-weight-light mb-0">{{ $pesanan->transaksi->pelanggan->alamat }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-light mb-0">{{ $pesanan->jumlah_bar }} bar</p>
                                                <p class="text-sm font-weight-light mb-0">{{ $pesanan->jumlah_m3 }} m3</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-light mb-0"> Rp. {{ number_format($pesanan->harga_pesanan, 0, ',', '.') }}</p>
                                            </td>
                                            <td class="text-center">
                                                @if ($pesanan->transaksi->tagihan->status_tagihan === 'Sudah Bayar' || $pesanan->transaksi->tagihan->status_tagihan === 'Diproses')
                                                    <p class="text-sm font-weight-light mb-0">{{ date('d/m/Y', strtotime($pesanan->transaksi->tagihan->tanggal_pembayaran)) }}</p>
                                                    <p class="text-sm font-weight-light mb-0">{{ date('H:i:s', strtotime($pesanan->transaksi->tagihan->tanggal_pembayaran)) }}</p>
                                                @else
                                                    <p class="text-sm font-weight-light text-danger mb-0">Belum Bayar</p>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($pesanan->transaksi->tagihan->status_tagihan === 'Sudah Bayar' || $pesanan->transaksi->tagihan->status_tagihan === 'Diproses')
                                                    <p class="text-sm font-weight-light mb-0">Tunai</p>
                                                @else
                                                    <p class="text-sm font-weight-light text-danger mb-0">Belum Bayar</p>
                                                @endif
                                            </td>
                                        </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <p class="fw-light text-sm mt-5">Pesanan tidak ditemukan.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>                                                                                                                                                                  
                        </table>
                        <div class="text-center mt-5" id="noResultsMessage_detailPenjualan" style="display: none;">
                            <p class="fw-light">Pesanan tidak ditemukan.</p>
                        </div>
                    </div>
                    {{-- Modal --}}
                    <div class="modal fade" id="exportModalDetail" tabindex="-1" aria-labelledby="exportModalDetailLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exportModalBOPLabel">Export Laporan BOP</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <p>Silakan pilih format untuk mengekspor laporan Detail Penjual:</p>
                              <div class="d-grid gap-2">
                                <button id="exportExcel_detail" type="button" class="btn btn-primary">Excel</button>
                                <button id="exportCSV_detail" type="button" class="btn btn-primary">CSV</button>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Tutup</button>
                            </div>
                          </div>
                        </div>
                      </div>

                    {{-- Pagination --}}
                    <div class="pt-4 d-flex">                     
                        <div class="col">
                            <p class="text-sm">Menampilkan {{ $detail_penjualans->firstItem() }} hingga {{ $detail_penjualans->lastItem() }} dari total {{ $detail_penjualans->total() }} data</p>
                        </div>
                        <div class="col">
                            <ul class="pagination pagination-primary justify-content-end">
                                @php
                                    $queryParamsDetailPenjualan = ['detail_penjualans' => $detail_penjualans->currentPage()];
                                    $prevPageUrlDetailPenjualan = $detail_penjualans->previousPageUrl();
                                    $nextPageUrlDetailPenjualan = $detail_penjualans->nextPageUrl();
                                    
                                    // Mendapatkan nomor halaman saat ini
                                    $currentPage = $detail_penjualans->currentPage();
                                    
                                    // Batasan jumlah angka yang ditampilkan
                                    $maxPagesToShow = 5;
                                    
                                    // Mendapatkan rentang angka yang ditampilkan
                                    $pageRange = $detail_penjualans->getUrlRange(max($currentPage - floor($maxPagesToShow / 2), 1), min($currentPage + floor($maxPagesToShow / 2), $detail_penjualans->lastPage()));
                                @endphp
                                
                                @if ($detail_penjualans->onFirstPage())
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span class="material-icons">keyboard_arrow_left</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $prevPageUrlDetailPenjualan ? $prevPageUrlDetailPenjualan . '&' . http_build_query(request()->except('detail_penjualans')) : '#' }}" aria-label="Previous">
                                            <span class="material-icons">keyboard_arrow_left</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                @endif
                                
                                @foreach ($pageRange as $page => $url)
                                    <li class="page-item {{ $page == $detail_penjualans->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url . '&' . http_build_query(request()->except('detail_penjualans')) }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                
                                @if ($detail_penjualans->hasMorePages())
                                    @php
                                        // Menghitung angka selanjutnya
                                        $nextPageNumber = $currentPage + 1;
                                    @endphp
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $nextPageUrlDetailPenjualan ? $nextPageUrlDetailPenjualan . '&' . http_build_query(request()->except('detail_penjualans')) : '#' }}" aria-label="Next">
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
        {{-- Tabel Laporan Omzet --}}
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col d-flex align-items-center">
                            <h4 class="card-title">Laporan Omzet</h4>
                            <span class="mt-1 ms-3">
                                <button id="exportLaporanBOP" class="btn btn-primary btn-sm shadow-none me-2" data-bs-toggle="modal" data-bs-target="#exportModalOmzet">Export</button>
                            </span>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col d-flex align-items-center text-dark">
                            <span class="text-sm me-2">Menampilkan </span>
                            <form action="{{ route('Laporan') }}" method="get" class="form-inline me-2">
                                <select name="perPage_omzet" id="perPage_omzet" class="form-control border rounded px-2" onchange="this.form.submit()">
                                    <option value="10" {{ $perPage_omzet == 10 ? 'selected' : '' }}>10</option>
                                    <option value="50" {{ $perPage_omzet == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $perPage_omzet == 100 ? 'selected' : '' }}>100</option>
                                    <option value="{{ $laporan_omzet->total() }}" {{ $perPage_omzet == $laporan_omzet->total() ? 'selected' : '' }}>Semua</option>
                                </select>
                            </form>
                            <span class="text-sm">data</span>
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
                <div class="card-body px-3 pt-0 pb-2" style="min-height: 430px;">
                    <div class="table-responsive p-0" style="min-height:380px; max-height: 380px; overflow-y: auto;">
                        <table class="table align-items-center mb-0" id="table_laporanOmzet">
                            <thead class="sticky-top bg-white z-index-1">
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Resi</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Pelanggan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tujuan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Jumlah Bar</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Jumlah M3</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Omzet</th>
                                </tr>
                            </thead>
                            <tbody id="table_laporanOmzet_body" class="text-dark">
                                    @forelse($laporan_omzet as $pesanan)
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-bold mb-0">{{ $pesanan->transaksi->resi_transaksi }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-light mb-0">{{ $pesanan->tanggal_pesanan }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-light mb-0">{{ $pesanan->transaksi->pelanggan->nama_perusahaan }}</p>
                                            </td>
                                            <td class="text-wrap">
                                                <p class="text-sm font-weight-light mb-0">{{ $pesanan->transaksi->pelanggan->alamat }}</p>
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
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <p class="fw-light text-sm mt-5">Pesanan tidak ditemukan.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                            </tbody>
                        </table>
                        <div class="text-center mt-5" id="noResultsMessage_laporanOmzet" style="display: none;">
                            <p class="fw-light">Pesanan tidak ditemukan.</p>
                        </div>
                    </div>
                    <div class="px-3">
                        <hr class="mb-0">
                        <div class="d-flex mt-3 px-5">
                            <div class="col">
                                <p class="text-xs text-uppercase fw-bold text-secondary">Total :</p>
                            </div>
                            <div class="col">
                                <p class="text-sm text-end fw-bold text-primary">Rp. {{ number_format($total_omzet, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- Modal --}}
                    <div class="modal fade" id="exportModalOmzet" tabindex="-1" aria-labelledby="exportModalOmzetLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exportModalBOPLabel">Export Laporan BOP</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <p>Silakan pilih format untuk mengekspor laporan Omzet:</p>
                              <div class="d-grid gap-2">
                                <button id="exportExcel_omzet" type="button" class="btn btn-primary">Excel</button>
                                <button id="exportCSV_omzet" type="button" class="btn btn-primary">CSV</button>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Tutup</button>
                            </div>
                          </div>
                        </div>
                    </div>

                    {{-- Pagination --}}
                    <div class="pt-4 d-flex">
                        <div class="col">
                            <p class="text-sm">Menampilkan {{ $laporan_omzet->firstItem() }} hingga {{ $laporan_omzet->lastItem() }} dari total {{ $laporan_omzet->total() }} data</p>
                        </div>
                        <div class="col">
                            <ul class="pagination pagination-primary justify-content-end">
                                @php
                                    $queryParamsOmzet = ['laporan_omzet' => $laporan_omzet->currentPage()];
                                    $prevPageUrlOmzet = $laporan_omzet->previousPageUrl();
                                    $nextPageUrlOmzet = $laporan_omzet->nextPageUrl();
                                    
                                    // Mendapatkan nomor halaman saat ini
                                    $currentPage = $laporan_omzet->currentPage();
                                    
                                    // Batasan jumlah angka yang ditampilkan
                                    $maxPagesToShow = 5;
                                    
                                    // Mendapatkan rentang angka yang ditampilkan
                                    $pageRange = $laporan_omzet->getUrlRange(max($currentPage - floor($maxPagesToShow / 2), 1), min($currentPage + floor($maxPagesToShow / 2), $laporan_omzet->lastPage()));
                                @endphp
                                
                                @if ($laporan_omzet->onFirstPage())
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span class="material-icons">keyboard_arrow_left</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $prevPageUrlOmzet ? $prevPageUrlOmzet . '&' . http_build_query(request()->except('laporan_omzet')) : '#' }}" aria-label="Previous">
                                            <span class="material-icons">keyboard_arrow_left</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                @endif
                                
                                @foreach ($pageRange as $page => $url)
                                    <li class="page-item {{ $page == $laporan_omzet->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url . '&' . http_build_query(request()->except('laporan_omzet')) }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                
                                @if ($laporan_omzet->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $nextPageUrlOmzet ? $nextPageUrlOmzet . '&' . http_build_query(request()->except('laporan_omzet')) : '#' }}" aria-label="Next">
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
        {{-- Tabel Laporan BOP --}}
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col d-flex align-items-center">
                            <h4 class="card-title">Laporan BOP</h4>
                            <span class="mt-1 ms-3">
                              <button id="exportLaporanBOP" class="btn btn-primary btn-sm shadow-none me-2" data-bs-toggle="modal" data-bs-target="#exportModalBOP">Export</button>
                            </span>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col d-flex align-items-center text-dark">
                            <span class="text-sm me-2">Menampilkan </span>
                            <form action="{{ route('Laporan') }}" method="get" class="form-inline me-2">
                                <select name="perPage_bop" id="perPage_bop" class="form-control border rounded px-2" onchange="this.form.submit()">
                                    <option value="10" {{ $perPage_bop == 10 ? 'selected' : '' }}>10</option>
                                    <option value="50" {{ $perPage_bop == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $perPage_bop == 100 ? 'selected' : '' }}>100</option>
                                    <option value="{{ $laporan_bop->total() }}" {{ $perPage_bop == $laporan_bop->total() ? 'selected' : '' }}>Semua</option>
                                </select>
                            </form>
                            <span class="text-sm">data</span>
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
                <div class="card-body px-3 pt-0 pb-2" style="min-height: 430px;">
                    <div class="table-responsive p-0" style="min-height: 380px; max-height: 380px; overflow-y: auto;">
                        <table class="table align-items-center mb-0" id="table_laporanBOP">
                            <thead class="sticky-top bg-white z-index-1">
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Resi Pengiriman</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tanggal Pengiriman</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Pelanggan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tujuan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Sopir</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Mobil</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">BOP</th>
                                </tr>
                            </thead>
                            <tbody id="table_laporanBOP_body" class="text-dark">
                                @forelse($laporan_bop as $pengiriman)
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
                                        <td class="text-center">
                                            <p class="text-sm font-weight-light mb-0">{{ $pengiriman->pesanan->transaksi->pelanggan->nama_perusahaan }}</p>
                                        </td>
                                        <td class="text-wrap">
                                            <p class="text-sm font-weight-light mb-0">{{ $pengiriman->pesanan->transaksi->pelanggan->alamat }}</p>
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
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <p class="fw-light text-sm mt-5">Pesanan tidak ditemukan.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="text-center mt-5" id="noResultsMessage_laporanBOP" style="display: none;">
                            <p class="fw-light">Pesanan tidak ditemukan.</p>
                        </div>
                    </div>

                    {{-- Modal --}}
                    <div class="modal fade" id="exportModalBOP" tabindex="-1" aria-labelledby="exportModalBOPLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exportModalBOPLabel">Export Laporan BOP</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <p>Silakan pilih format untuk mengekspor laporan BOP:</p>
                              <div class="d-grid gap-2">
                                <button id="exportExcel_BOP" type="button" class="btn btn-primary">Excel</button>
                                <button id="exportCSV_BOP" type="button" class="btn btn-primary">CSV</button>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Tutup</button>
                            </div>
                          </div>
                        </div>
                      </div>

                    {{-- Pagination --}}
                    <div class="pt-4 d-flex">
                        <div class="col">
                            <p class="text-sm">Menampilkan {{ $laporan_bop->firstItem() }} hingga {{ $laporan_bop->lastItem() }} dari total {{ $laporan_bop->total() }} data</p>
                        </div>
                        <div class="col">
                            <ul class="pagination pagination-primary justify-content-end">
                                @php
                                    $queryParamsBOP = ['laporan_omzet' => $laporan_bop->currentPage()];
                                    $prevPageUrlBOP = $laporan_bop->previousPageUrl();
                                    $nextPageUrlBOP = $laporan_bop->nextPageUrl();
                                    
                                    // Mendapatkan nomor halaman saat ini
                                    $currentPage = $laporan_bop->currentPage();
                                    
                                    // Batasan jumlah angka yang ditampilkan
                                    $maxPagesToShow = 5;
                                    
                                    // Mendapatkan rentang angka yang ditampilkan
                                    $pageRange = $laporan_bop->getUrlRange(max($currentPage - floor($maxPagesToShow / 2), 1), min($currentPage + floor($maxPagesToShow / 2), $laporan_bop->lastPage()));
                                @endphp
                                
                                @if ($laporan_bop->onFirstPage())
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span class="material-icons">keyboard_arrow_left</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $prevPageUrlBOP ? $prevPageUrlBOP . '&' . http_build_query(request()->except('laporan_bop')) : '#' }}" aria-label="Previous">
                                            <span class="material-icons">keyboard_arrow_left</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                @endif
                                
                                @foreach ($pageRange as $page => $url)
                                    <li class="page-item {{ $page == $laporan_bop->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url . '&' . http_build_query(request()->except('laporan_bop')) }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                
                                @if ($laporan_bop->hasMorePages())
                                    @php
                                        // Menghitung angka selanjutnya
                                        $nextPageNumber = $currentPage + 1;
                                    @endphp
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $nextPageUrlBOP ? $nextPageUrlBOP . '&' . http_build_query(request()->except('laporan_bop')) : '#' }}" aria-label="Next">
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

    {{-- Export --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
          // Fungsi untuk mengekspor ke format Excel
          document.getElementById('exportExcel_detail').addEventListener('click', function() {
            exportDataToExcel();
          });
      
          // Fungsi untuk mengekspor ke format CSV
          document.getElementById('exportCSV_detail').addEventListener('click', function() {
            exportDataToCSV();
          });
      
          // Fungsi untuk mengekspor data ke format Excel
          function exportDataToExcel() {
            // Mendapatkan tabel dengan ID
            var table = document.getElementById('table_detailPenjualan');
      
            // Mengonversi tabel HTML ke format Excel
            var html = table.outerHTML;
            var uri = 'data:application/vnd.ms-excel;base64,';
      
            // Menambahkan metadata Excel
            var template = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
            template += '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
            template += '</head><body><table>{table}</table></body></html>';
      
            var base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))); };
            var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }); };
      
            var ctx = { worksheet: 'laporan_detail_penjualan', table: html };
            var href = uri + base64(format(template, ctx));
      
            // Membuat tombol unduh dan mengarahkannya ke file Excel
            var link = document.createElement("a");
            link.href = href;
            link.download = "laporan_detail_penjualan.xls";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
          }
      
          // Fungsi untuk mengekspor data ke format CSV
          function exportDataToCSV() {
            // Mendapatkan tabel dengan ID
            var table = document.getElementById('table_detailPenjualan');
            var rows = table.querySelectorAll("tr");
      
            // Inisialisasi string CSV dengan header kolom
            var csv = "Resi,Tanggal,Pelanggan,Tujuan,Jumlah Pesanan,Harga,Waktu Payment,Payment Methode\n";
      
            // Loop melalui setiap baris tabel, mendapatkan data dari setiap kolom, dan menambahkannya ke string CSV
            for (var i = 1; i < rows.length; i++) {
              var cells = rows[i].querySelectorAll("td");
              for (var j = 0; j < cells.length; j++) {
                csv += cells[j].innerText.replace(",", "") + ",";
              }
              csv += "\n";
            }
      
            // Membuat objek blob CSV
            var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
      
            // Membuat link untuk unduhan CSV
            var link = document.createElement("a");
            var url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", "laporan_detail_penjualan.csv");
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
          }
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
          // Fungsi untuk mengekspor ke format Excel
          document.getElementById('exportExcel_omzet').addEventListener('click', function() {
            exportDataToExcel();
          });
      
          // Fungsi untuk mengekspor ke format CSV
          document.getElementById('exportCSV_omzet').addEventListener('click', function() {
            exportDataToCSV();
          });
      
          // Fungsi untuk mengekspor data ke format Excel
          function exportDataToExcel() {
            // Mendapatkan tabel dengan ID
            var table = document.getElementById('table_laporanOmzet');
      
            // Mengonversi tabel HTML ke format Excel
            var html = table.outerHTML;
            var uri = 'data:application/vnd.ms-excel;base64,';
      
            // Menambahkan metadata Excel
            var template = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
            template += '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
            template += '</head><body><table>{table}</table></body></html>';
      
            var base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))); };
            var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }); };
      
            var ctx = { worksheet: 'laporan_bop', table: html };
            var href = uri + base64(format(template, ctx));
      
            // Membuat tombol unduh dan mengarahkannya ke file Excel
            var link = document.createElement("a");
            link.href = href;
            link.download = "laporan_omzet.xls";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
          }
      
          // Fungsi untuk mengekspor data ke format CSV
          function exportDataToCSV() {
            // Mendapatkan tabel dengan ID
            var table = document.getElementById('table_laporanOmzet');
            var rows = table.querySelectorAll("tr");
      
            // Inisialisasi string CSV dengan header kolom
            var csv = "Resi,Tanggal,Pelanggan,Tujuan,Jumlah Bar,Jumlah M3,Omzet\n";
      
            // Loop melalui setiap baris tabel, mendapatkan data dari setiap kolom, dan menambahkannya ke string CSV
            for (var i = 1; i < rows.length; i++) {
              var cells = rows[i].querySelectorAll("td");
              for (var j = 0; j < cells.length; j++) {
                csv += cells[j].innerText.replace(",", "") + ",";
              }
              csv += "\n";
            }
      
            // Membuat objek blob CSV
            var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
      
            // Membuat link untuk unduhan CSV
            var link = document.createElement("a");
            var url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", "laporan_omset.csv");
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
          }
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
          // Fungsi untuk mengekspor ke format Excel
          document.getElementById('exportExcel_BOP').addEventListener('click', function() {
            exportDataToExcel();
          });
      
          // Fungsi untuk mengekspor ke format CSV
          document.getElementById('exportCSV_BOP').addEventListener('click', function() {
            exportDataToCSV();
          });
      
          // Fungsi untuk mengekspor data ke format Excel
          function exportDataToExcel() {
            // Mendapatkan tabel dengan ID
            var table = document.getElementById('table_laporanBOP');
      
            // Mengonversi tabel HTML ke format Excel
            var html = table.outerHTML;
            var uri = 'data:application/vnd.ms-excel;base64,';
      
            // Menambahkan metadata Excel
            var template = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
            template += '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
            template += '</head><body><table>{table}</table></body></html>';
      
            var base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))); };
            var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }); };
      
            var ctx = { worksheet: 'laporan_bop', table: html };
            var href = uri + base64(format(template, ctx));
      
            // Membuat tombol unduh dan mengarahkannya ke file Excel
            var link = document.createElement("a");
            link.href = href;
            link.download = "laporan_bop.xls";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
          }
      
          // Fungsi untuk mengekspor data ke format CSV
          function exportDataToCSV() {
            // Mendapatkan tabel dengan ID
            var table = document.getElementById('table_laporanBOP');
            var rows = table.querySelectorAll("tr");
      
            // Inisialisasi string CSV dengan header kolom
            var csv = "Resi Pengiriman,Tanggal Pengiriman,Pelanggan,Tujuan,Sopir,Mobil,BOP\n";
      
            // Loop melalui setiap baris tabel, mendapatkan data dari setiap kolom, dan menambahkannya ke string CSV
            for (var i = 1; i < rows.length; i++) {
              var cells = rows[i].querySelectorAll("td");
              for (var j = 0; j < cells.length; j++) {
                csv += cells[j].innerText.replace(",", "") + ",";
              }
              csv += "\n";
            }
      
            // Membuat objek blob CSV
            var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
      
            // Membuat link untuk unduhan CSV
            var link = document.createElement("a");
            var url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", "laporan_bop.csv");
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
          }
        });
    </script>
    
@endsection