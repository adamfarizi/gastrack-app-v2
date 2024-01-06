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
                    <a class="nav-link text-dark " href="{{ url('/pembelian') }}">
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
                    <a class="nav-link text-white active bg-gradient-primary " href="{{ url('/sopir&kendaraan') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">local_shipping</i>
                        </div>
                        <span class="nav-link-text ms-1">Sopir & Kendaraan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('/pengguna') }}">
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
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Sopir</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Sopir</h6>
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
                                    <span class="font-weight-bold"> Super Admin </span>
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
        {{-- Total sopir --}}
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-primary shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="fa fa-solid fa-vest opacity-10"></i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Total Sopir</p>
                        <h5 class="mb-0">{{ $total_sopir }} sopir</h5>
                    </div>
                </div>
            </div>
        </div>
        {{-- Total kendaraan --}}
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-primary shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">local_shipping</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Total Kendaraan</p>
                        <h5 class="mb-0">{{ $total_kendaraan }} kendaraan</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <div class="row">
            {{-- Tabel sopir --}}
            <div class="col-12 col-md-6 mb-4">
                <div class="card">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h6>Sopir</h6>
                        <a type="button" class="btn btn-sm bg-gradient-primary border-end" data-bs-toggle="modal"
                            data-bs-target="#tambahsopir">
                            <span> <i class="fa fa-solid fa-plus me-2" style="color: #ffffff;"></i></span>
                            Tambah Sopir
                        </a>
                    </div>
                    <div class="card-body px-3 pt-0 pb-2" style="min-height: 370px;">
                        <div class="table-responsive p-0" style="max-height: 350px; overflow-y: auto;">
                            <table class="table align-items-center mb-0">
                                <thead class="sticky-top bg-white z-index-1">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Pengguna</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No Hp</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Ketersediaan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                @foreach ($sopirs as $sopir)
                                    <tbody class="border-0" id="table-sopir">
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="avatar avatar-sm me-3 bg-dark">
                                                        <i class="fa fa-solid fa-vest opacity-10"></i>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $sopir->nama }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $sopir->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $sopir->no_hp }}</p>
                                            </td>
                                            <td class="text-center">
                                                @if ($sopir->ketersediaan_sopir === 'tersedia')
                                                    <span class="badge badge-sm bg-gradient-success">Tersedia</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Tdk Tersedia</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ url('/sopir/status/'.$sopir->id_sopir) }}" method="POST">
                                                    @csrf
                                                    @if ($sopir->status_sopir == 'aktif')
                                                        <button type="submit" href class="badge badge-sm bg-gradient-success border-0">Aktif</button>
                                                    @else
                                                        <button type="submit" class="badge badge-sm bg-gradient-danger border-0">Tidak Aktif</button>
                                                    @endif
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v text-xs"></i>
                                                </a>
                                                <ul class="shadow dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">                                                  
                                                    <li>
                                                        <a class="dropdown-item border-radius-md" href="{{ url('/sopir/edit/'. $sopir->id_sopir) }}">
                                                            <i class="fa fa-solid fa-pen" style="color: #252f40;"></i>
                                                            <span class="ms-3">Edit</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item border-radius-md" data-bs-toggle="modal" data-bs-target="#confirmDeleteSopir">
                                                            <i class="fa fa-solid fa-trash" style="color: #ea0606;"></i>
                                                            <span class="ms-3 text-danger">Hapus</span>
                                                        </a>                                                                                                                                                          
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Tabel kendaraan --}}
            <div class="col-12 col-md-6 mb-4">
                <div class="card">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h6>Kendaraan</h6>
                        <a type="button" class="btn btn-sm bg-gradient-primary border-end" data-bs-toggle="modal"
                            data-bs-target="#tambahkendaraan">
                            <span> <i class="fa fa-solid fa-plus me-2" style="color: #ffffff;"></i></span>
                            Tambah Kendaraan
                        </a>
                    </div>
                    <div class="card-body px-3 pt-0 pb-2" style="min-height: 370px;">
                        <div class="table-responsive p-0" style="max-height: 350px; overflow-y: auto;">
                            <table class="table align-items-center mb-0">
                                <thead class="sticky-top bg-white z-index-1">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Identitas Kendaraan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Jenis</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Ketersediaan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                @foreach ($kendaraans as $kendaraan)
                                    <tbody class="border-0" id="table-kendaraan">
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="avatar avatar-sm me-3 bg-dark">
                                                        <i class="material-icons opacity-10">local_shipping</i>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $kendaraan->nopol_mobil }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $kendaraan->identitas_mobil }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $kendaraan->jenis_mobil }}</p>
                                                <p class="text-xs text-secondary mb-0">T-{{ str_pad($kendaraan->id_mobil, 3, '0', STR_PAD_LEFT) }}</p>
                                            </td>
                                            <td class="text-center">
                                                @if ($kendaraan->ketersediaan_mobil === 'tersedia')
                                                    <span class="badge badge-sm bg-gradient-success">Tersedia</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Tdk Tersedia</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ url('/kendaraan/status/'.$kendaraan->id_mobil) }}" method="POST">
                                                    @csrf
                                                    @if ($kendaraan->status_mobil == 'aktif')
                                                        <button type="submit" href class="badge badge-sm bg-gradient-success border-0">Aktif</button>
                                                    @else
                                                        <button type="submit" class="badge badge-sm bg-gradient-danger border-0">Tidak Aktif</button>
                                                    @endif
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v text-xs"></i>
                                                </a>
                                                <ul class="shadow dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">                                                  
                                                    <li>
                                                        <a class="dropdown-item border-radius-md" href="{{ url('/kendaraan/edit/'. $kendaraan->id_mobil) }}">
                                                            <i class="fa fa-solid fa-pen" style="color: #252f40;"></i>
                                                            <span class="ms-3">Edit</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item border-radius-md" data-bs-toggle="modal" data-bs-target="#confirmDeleteKendaraan">
                                                            <i class="fa fa-solid fa-trash" style="color: #ea0606;"></i>
                                                            <span class="ms-3 text-danger">Hapus</span>
                                                        </a>  
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi delete sopir --}}
    <form action="{{ url('/sopir/delete/' . $sopir->id_sopir) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('DELETE')
        <div class="modal fade" id="confirmDeleteSopir" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteSopirLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteSopirLabel">Konfirmasi Hapus</h5>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus sopir ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" onclick="closeModalSopir()">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
 

    {{-- Modal Konfirmasi delete kendaraan --}}
    <form action="{{ url('/kendaraan/delete/' . $kendaraan->id_mobil) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('DELETE')
        <div class="modal fade" id="confirmDeleteKendaraan" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteKendaraanLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteKendaraanLabel">Konfirmasi Hapus</h5>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus kendaraan ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" onclick="closeModalKendaraan()">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        function closeModalSopir() {
            $('#confirmDeleteSopir').modal('hide');
        }
    </script>

    <script>
        function closeModalKendaraan() {
            $('#confirmDeleteKendaraan').modal('hide');
        }
    </script> 

    @include('auth.sopir.create.create_sopir')
    @include('auth.sopir.create.create_kendaraan')
@endsection
