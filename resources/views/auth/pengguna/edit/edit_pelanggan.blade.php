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
                    <a class="nav-link text-dark" href="{{ url('/sopir') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">local_shipping</i>
                        </div>
                        <span class="nav-link-text ms-1">Sopir & Kendaraan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white active bg-gradient-primary " href="{{ url('/pengguna') }}">
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
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark">Pengguna</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit Pelanggan</li>                                                </ol>
                <h6 class="font-weight-bolder mb-0">Pelanggan</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <ul class="navbar-nav justify-content-end me-5">
                        <div class="d-flex py-1">
                            <div class="my-auto">
                                <img src="../assets/img/local/profil.png" class="border-radius-lg avatar-sm me-3 mt-1">
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
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h3 class="px-4 font-weight-bolder text-white">Edit Pelanggan</h3>
                            <p class="px-4 text-white">Silahkan ubah data diri pelanggan dengan benar</p>
                        </div>
                    </div>
                    <div class="card-body px-4">
                        <form role="form text-left border" action="{{ url('/pengguna/pelanggan/edit/' . $pelanggan->id_pelanggan) }}"
                            method="POST">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label>Nama Perusahaan</label>
                                    <div class="input-group input-group-outline mb-3 bg-white">
                                        <input name="nama_perusahaan" type="text" class="form-control" aria-label="nama"
                                            value="{{ $pelanggan->nama_perusahaan }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <label>Nama Pemilik</label>
                                    <div class="input-group input-group-outline mb-3 bg-white">
                                        <input name="nama_pemilik" type="text" class="form-control" aria-label="nama"
                                            value="{{ $pelanggan->nama_pemilik }}">
                                    </div>
                                </div>
                            </div>
                            <label>Email</label>
                            <div class="input-group input-group-outline mb-3 bg-white">
                                <input name="email" type="text" class="form-control" aria-label="email"
                                    value="{{ $pelanggan->email }}">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>No Hp <span class="text-danger">*</span></label>
                                    <div class="input-group mb-3 input-group-outline">
                                        <input name="no_hp" type="number" class="form-control" placeholder="Masukkan nomor hp"
                                            aria-label="no_hp" value="{{ $pelanggan->no_hp }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <label>Jadwal Bayar <span class="text-danger">*</span></label>
                                    <div class="input-group mb-3 input-group-outline">
                                        <select class="form-control px-2" aria-label="Jadwal Bayar" name="jadwal_bayar">
                                            <option value="2" {{ $pelanggan->jenis_pembayaran === '2' ? 'selected' : '' }}>2 Minggu</option>
                                            <option value="3" {{ $pelanggan->jenis_pembayaran === '3' ? 'selected' : '' }}>3 Minggu</option>
                                            <option value="4" {{ $pelanggan->jenis_pembayaran === '4' ? 'selected' : '' }}>4 Minggu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <label>Alamat <span class="text-danger">*</span></label>
                            <div class="input-group mb-3 input-group-outline">
                                <textarea name="alamat" type="text" class="form-control" placeholder="Masukkan alamat pelanggan"
                                    style="height: 70px; resize: none;" aria-label="alamat" value="">{{ $pelanggan->alamat }}</textarea>
                            </div>
                            <label>Password</label>
                            <div class="input-group input-group-outline mb-3">
                                <input name="old_password" type="password" class="form-control"
                                    aria-label="old_password" value="" placeholder="Password Lama">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-outline mb-3">
                                        <input name="new_password" type="password" class="form-control"
                                            aria-label="new_password" value="" placeholder="Password Baru">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-outline mb-3">
                                        <input name="new_password_confirmation" type="password" class="form-control"
                                            aria-label="new_password_confirmation" value="" placeholder="Konfirmasi Password Baru">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="submit"
                                    class="btn bg-gradient-primary btn-lg w-100 mt-4 mb-0" values="Update">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection