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
                    <a class="nav-link text-dark" href="{{ url('/laporan') }}">
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
                    <a class="nav-link text-white active bg-gradient-primary" href="{{ url('/penarikan') }}">
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
                    <a class="nav-link text-dark" href="{{ url('profil/'.Auth::user()->id_admin) }}">
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
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Penarikan BOP</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Penarikan BOP</h6>
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
        {{-- Tabel Penarikan --}}
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col d-flex">
                            <h4 class="card-title">Penarikan BOP Sopir</h4>
                            <span class="mt-1 ms-3">
                                <a class="me-2"></a>
                            </span>
                        </div>
                        <div class="col-md-3 col-sm-6 ml-auto">
                            <div class="input-group mb-3 border rounded-2">
                                <span class="input-group-text text-body me-2"><i class="fa fa-search"
                                        aria-hidden="true"></i></span>
                                <input type="text" class="form-control ms-2" id="searchInput_penarikanBOP"
                                    placeholder="Cari  ...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-3 pt-0" style="min-height: 230px;">
                    <div class="table-responsive p-0" style="max-height: 250px; overflow-y: auto;">
                        <table class="table align-items-center mb-0" id="table_penarikanBOP">
                            <thead class="sticky-top bg-white z-index-1">
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Kode Penarikan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tanggal Penarikan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nama Sopir</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Jumlah Penarikan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Proses</th>
                                </tr>
                            </thead>
                            <tbody id="table_penarikanBOP_body" class="text-dark">
                                @forelse ($penarikans as $penarikan)
                                    <tr>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-bold mb-0">{{ $penarikan->kode_penarikan }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-light mb-0">Tanggal : {{ date('d/m/Y', strtotime($penarikan->tanggal_penarikan)) }}</p>
                                            <p class="text-sm font-weight-light mb-0">Jam : {{ date('H:i:s', strtotime($penarikan->tanggal_penarikan)) }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-light mb-0">{{ $penarikan->sopir->nama }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-light mb-0">Rp. {{ number_format($penarikan->jumlah_penarikan, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ url('/penarikan/pengambilan/' . $penarikan->id_penarikan) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-icon btn-sm btn-primary" type="submit">
                                                    <span class="btn-inner--icon me-2"><i class="fa fa-solid fa-money-bill-transfer"></i></span>
                                                    <span class="btn-inner--text">Tarik saldo</span>
                                                </button>                                                
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <p class="fw-light mt-5">Penarikan tidak ditemukan.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>   
                        <div class="text-center mt-5" id="noResultsMessage_penarikanBOP" style="display: none;">
                            <p class="fw-light">Penarikan tidak ditemukan.</p>
                        </div>                     
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Riwayat Penarikan --}}
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col d-flex">
                            <h4 class="card-title">Riwayat Penarikan BOP Sopir</h4>
                            <span class="mt-1 ms-3">
                                <a class="me-2"></a>
                            </span>
                        </div>
                        <div class="col-md-3 col-sm-6 ml-auto">
                            <div class="input-group mb-3 border rounded-2">
                                <span class="input-group-text text-body me-2"><i class="fa fa-search"
                                        aria-hidden="true"></i></span>
                                <input type="text" class="form-control ms-2" id="searchInput_riwayat_penarikanBOP"
                                    placeholder="Cari  ...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-3 pt-0 pb-2" style="min-height: 430px;">
                    <div class="table-responsive p-0" style="min-height:380px; max-height: 380px; overflow-y: auto;">
                        <table class="table align-items-center mb-0" id="table_riwayat_penarikanBOP">
                            <thead class="sticky-top bg-white z-index-1">
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Kode Penarikan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tanggal Penarikan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nama Sopir</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Jumlah Penarikan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tanggal Pengambilan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Admin Pengambilan</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Status</th>
                                </tr>
                            </thead>
                            <tbody id="table_riwayat_penarikanBOP_body" class="text-dark">
                                @forelse ($riwayat_penarikans as $penarikan)
                                    <tr>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-bold mb-0">{{ $penarikan->kode_penarikan }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-light mb-0">Tanggal : {{ date('d/m/Y', strtotime($penarikan->tanggal_penarikan)) }}</p>
                                            <p class="text-sm font-weight-light mb-0">Jam : {{ date('H:i:s', strtotime($penarikan->tanggal_penarikan)) }}</p>                                        
                                        </td>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-light mb-0">{{ $penarikan->sopir->nama }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-light mb-0">Rp. {{ number_format($penarikan->jumlah_penarikan, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-light mb-0">Tanggal : {{ date('d/m/Y', strtotime($penarikan->tanggal_pengambilan)) }}</p>
                                            <p class="text-sm font-weight-light mb-0">Jam : {{ date('H:i:s', strtotime($penarikan->tanggal_pengambilan)) }}</p>                                        
                                        </td>
                                        <td class="text-center">
                                            @if ($penarikan->admin)
                                                <p class="text-sm font-weight mb-0">{{ $penarikan->admin->nama }}</p>
                                            @else
                                                <p class="text-sm font-weight mb-0">Belum Tarik</p>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($penarikan->status_penarikan === 'Sudah Tarik')
                                                <span class="badge badge-sm bg-gradient-success">Sudah Tarik</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-danger">Belum Tarik</span>
                                            @endif                                        
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <p class="fw-light mt-5">Penarikan tidak ditemukan.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>                                                                                                                                                                                           
                        </table>
                        <div class="text-center mt-5" id="noResultsMessage_riwayat_penarikanBOP" style="display: none;">
                            <p class="fw-light">Penarikan tidak ditemukan.</p>
                        </div>                     
                    </div>
                    {{-- Pagination --}}
                    <div class="pt-4 d-flex">
                        <div class="col">
                            <p class="text-sm">Menampilkan {{ $riwayat_penarikans->firstItem() }} hingga {{ $riwayat_penarikans->lastItem() }} dari total {{ $riwayat_penarikans->total() }} data</p>
                        </div>
                        <div class="col">
                            <ul class="pagination pagination-primary justify-content-end">
                                @if ($riwayat_penarikans->onFirstPage())
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous">
                                        <span class="material-icons">
                                            keyboard_arrow_left
                                        </span>
                                        <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $riwayat_penarikans->previousPageUrl() }}" aria-label="Previous">
                                        <span class="material-icons">
                                            keyboard_arrow_left
                                        </span>
                                        <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                @endif
                                @foreach ($riwayat_penarikans->getUrlRange(1, $riwayat_penarikans->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $riwayat_penarikans->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                @if ($riwayat_penarikans->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $riwayat_penarikans->nextPageUrl() }}" aria-label="Next">
                                        <span class="material-icons">
                                            keyboard_arrow_right
                                        </span>
                                        <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Next">
                                        <span class="material-icons">
                                            keyboard_arrow_right
                                        </span>
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#searchInput_penarikanBOP").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table_penarikanBOP_body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });

                var noResultsMessage = $("#noResultsMessage_penarikanBOP");
                if ($("#table_penarikanBOP_body tr:visible").length === 0) {
                    noResultsMessage.show();
                } else {
                    noResultsMessage.hide();
                }
            });

            $("#searchInput_riwayat_penarikanBOP").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table_riwayat_penarikanBOP_body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });

                var noResultsMessage = $("#noResultsMessage_riwayat_penarikanBOP");
                if ($("#table_riwayat_penarikanBOP_body tr:visible").length === 0) {
                    noResultsMessage.show();
                } else {
                    noResultsMessage.hide();
                }
            });
        });
    </script>
@endsection