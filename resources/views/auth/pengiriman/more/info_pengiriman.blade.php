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
                    <a class="nav-link text-white active bg-gradient-primary " href="{{ url('/pengiriman') }}">
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
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark">Pengiriman</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail Pengiriman</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Detail Pengiriman</h6>
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
    @foreach ($pengirimans as $pengiriman)
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card pb-4">
                    <div class="card-header pb-0">
                        <h4 class="text-primary">Detail Pengiriman</h4>
                        <hr>
                    </div>
                    <div class="card-body px-3 pt-0 pb-2 text-dark">
                        <div class="border rounded p-3 mb-3">
                            <h5 class="ms-2">Resi Pengiriman : <span class="fw-light">{{ $pengiriman->kode_pengiriman }}</span></h5>
                            <div class="row">
                                <div class="col mx-2">
                                    <div class="">
                                        <div class="row ms-2">
                                            <div class="col px-0">
                                                <p class="mb-0">- <span class="fw-bold">Pelanggan</span></p>
                                                <p class="mb-0">- <span class="fw-bold">Permintaan Gas</span></p>
                                                <p class="mb-0">- <span class="fw-bold">Gas Diterima</span></p>
                                                <p class="mb-0">- <span class="fw-bold">Alamat</span></p>
                                            </div>
                                            <div class="col-9 text-dark">
                                                <p class="mb-0 fw-bold">: <span class="fw-light">{{ $pelanggan->nama_perusahaan }}</span></p>
                                                <p class="mb-0 fw-bold">: <span class="fw-light">{{ $pengiriman->gas_permintaan }} bar</span></p>
                                                <p class="mb-0 fw-bold">: <span class="fw-light">{{ $pengiriman->pesanan->jumlah_bar }} bar / {{ $pengiriman->pesanan->jumlah_m3 }} m<sup>3</sup></span></p>
                                                <p class="mb-0 fw-bold">: <span class="fw-light">{{ $pelanggan->alamat }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col mx-2">
                                    <div class="">
                                        <div class="row ms-2">
                                            <div class="col px-0">
                                                <p class="mb-0">- <span class="fw-bold">Identitas Sopir</span></p>
                                                <p class="mb-0">- <span class="fw-bold">Identitas Mobil</span></p>
                                                <p class="mb-0">- <span class="fw-bold">Sisa Gas</span></p>
                                            </div>
                                            <div class="col-9 text-dark">
                                                <p class="mb-0 fw-bold">: <span class="fw-light">{{ $sopir->nama }}</span></p>
                                                <p class="mb-0 fw-bold">: <span class="fw-light">{{ $mobil->identitas_mobil }} ({{ $mobil->nopol_mobil }})</span></p>
                                                @if ($pengiriman->sisa_gas === null)
                                                    <p class="mb-0 fw-bold">: <span class="fw-light">tidak tersisa</span></p>
                                                @else
                                                    <p class="mb-0 fw-bold">: <span class="fw-light">{{ $pengiriman->sisa_gas }} bar</span></p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row px-1">
                            <div class="border rounded col mx-2 p-3">
                                <div class="mb-2">
                                    <h5>Gas Masuk</h5>
                                    <div class="row ms-2">
                                        <div class="col px-0">
                                            <p class="mb-0">- <span class="fw-bold">Gas Masuk</span></p>
                                            <p class="mb-0">- <span class="fw-bold">Waktu Dikirim</span></p>
                                            <p class="">- <span class="fw-bold">Bukti Gas Masuk</span></p>
                                        </div>
                                        <div class="col-9 text-dark">
                                            <p class="mb-0 fw-bold">: <span class="fw-light">{{ $pengiriman->kapasitas_gas_masuk }} bar</span></p>
                                            <p class="mb-0 fw-bold">: <span class="fw-light">{{ date('d/m/Y H:i', strtotime($pengiriman->waktu_pengiriman)) }}</span></p>
                                            <p class="mb-0 fw-bold">: </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2 text-center">
                                    @if ($pengiriman->bukti_gas_masuk == null)
                                        <div class="w-100 rounded" style="background-color: #dee2e6;">
                                            <p class="text-white py-9">Belum ada bukti</p>
                                        </div>
                                    @else
                                        <img src="{{ asset('img/GasMasuk/'.$pengiriman->bukti_gas_masuk) }}"
                                            class="rounded" alt="" style="max-width: 500px; max-height: 500px">
                                    @endif
                                </div>
                            </div>
                            <div class="border rounded col mx-2 p-3">
                                <div class="mb-2">
                                    <h5>Gas Keluar</h5>
                                    <div class="row ms-2">
                                        <div class="col px-0">
                                            <p class="mb-0">- <span class="fw-bold">Gas Keluar</span></p>
                                            <p class="mb-0">- <span class="fw-bold">Waktu Diterima</span></p>
                                            <p class="">- <span class="fw-bold">Bukti Gas Keluar</span></p>
                                        </div>
                                        <div class="col-9 text-dark">
                                            <p class="mb-0 fw-bold">: <span class="fw-light">{{ $pengiriman->kapasitas_gas_keluar }} bar / {{ $pengiriman->pesanan->jumlah_m3 }} m<sup>3</sup></span></p>
                                            <p class="mb-0 fw-bold">: <span class="fw-light">{{ date('d/m/Y H:i', strtotime($pengiriman->waktu_diterima)) }}</span></p>
                                            <p class="mb-0 fw-bold">: </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2 text-center">
                                    @if ($pengiriman->bukti_gas_keluar == null)
                                        <div class="w-100 rounded" style="background-color: #dee2e6;">
                                            <p class="text-white py-9">Belum ada bukti</p>
                                        </div>
                                    @else
                                        <img src="{{ asset('img/GasKeluar/'.$pengiriman->bukti_gas_keluar) }}"
                                        class="rounded" alt="" style="max-width: 500px; max-height: 500px">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection