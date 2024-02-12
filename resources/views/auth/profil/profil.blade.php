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
                    <a class="nav-link text-white active bg-gradient-primary " href="{{ url('/profil/'.Auth::user()->id_admin) }}">
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
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Profil</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Profil</h6>
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
    <div class="container-fluid">
        <div class="page-header min-height-300 border-radius-xl"
            style="background-image: url('../assets/img/local/bg_login2.png'); background-position-y: 50%;">
            <span class="mask bg-gradient-primary opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n8 mb-3 overflow-hidden">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative ">
                        <img src="../assets/img/local/profil.png" alt="profile_image"
                            class="w-100 border-radius-lg shadow-sm items-center">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ Auth::user()->nama }}
                        </h5>
                        <p class="mb-0 font-weight-normal text-sm">
                            {{ Auth::user()->email }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3 mt-3">
                        <div class="col-md-8 d-flex align-items-center">
                            <h5 class="font-weight-bolder text-primary text-gradient">Edit Profil</h5>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <form role="form text-left" action="{{ url('/profil/edit/'.Auth::user()->id_admin) }}" method="POST">
                            @csrf
                            <label>Nama</label>
                            <div class="input-group mb-3 input-group-outline">
                                <input name="nama" type="text" class="form-control" placeholder="Masukkan nama anda"
                                    aria-label="nama" value="{{ $admin->nama }}">
                            </div>
                            <label>Email</label>
                            <div class="input-group mb-3 input-group-outline">
                                <input name="email" type="email" class="form-control" placeholder="Masukkan email anda"
                                    aria-label="email" value="{{ $admin->email }}">
                            </div>
                            <div class="text-center ">
                                <button type="submit" name="submit" class="btn bg-gradient-success w-100 mt-4 mb-0"
                                    values="Update">Update</button>
                            </div>
                            <div class="text-center">
                                <button type="button" name="modal" class="btn bg-gradient-primary w-100 mt-4 mb-0"
                                    data-bs-toggle="modal" data-bs-target="#exampleModalMessage">Ganti Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal ganti password --}}
        <div class="col-md-4">
            <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ganti Password</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('/profil/edit/password/'.Auth::user()->id_admin) }}" method="post" role="form text-left">
                                @csrf
                                <label>Password</label>
                                <div class="input-group input-group-outline mb-3">
                                    <input name="old_password" type="password" class="form-control"
                                        aria-label="old_password" value="" placeholder="Password Lama">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Password Baru</label>
                                        <div class="input-group input-group-outline mb-3">
                                            <input name="new_password" type="password" class="form-control"
                                            aria-label="new_password" value="" placeholder="Password Baru">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Konfirmasi Password Baru</label>
                                        <div class="input-group input-group-outline mb-3">
                                            <input name="new_password_confirmation" type="password" class="form-control"
                                                aria-label="new_password_confirmation" value="" placeholder="Konfirmasi Password Baru">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="submit"
                                        class="btn bg-gradient-success w-100 mt-4 mb-0">Ganti Password</button>
                                </div>
                                <div class="text-center">
                                    <a type="button" name="modal" data-bs-dismiss="modal"
                                        class="btn bg-gradient-primary w-100 mt-4 mb-0">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection