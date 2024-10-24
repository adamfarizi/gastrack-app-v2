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
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark">Detail Pesanan</a></li>
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
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card pb-4">
                <div class="card-header pb-0">
                    <h4 class="text-primary">Detail Pengiriman</h4>
                    <hr>
                </div>
                <div class="card-body px-3 pt-0 pb-2 text-dark">
                    {{-- Header --}}
                    <div class="row mx-2">
                        <div class="mb-3 col-md-6">
                            @php
                                // Daftar nama hari dan bulan dalam Bahasa Indonesia
                                $namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                                // Mengubah string tanggal ke timestamp
                                $timestamp = strtotime($pengiriman->pesanan->tanggal_pesanan);
                                // Mengambil nama hari dan tanggal
                                $hari = $namaHari[date('w', $timestamp)];
                            @endphp
                            <div class="row">
                                <p class="col-4 fw-bold text-dark mb-0">Resi Pengiriman</p>
                                <p class="col fw-bold text-dark mb-0">: <span
                                        class="ms-1 col fw-light text-second">{{ $pengiriman->kode_pengiriman }}</span>
                                </p>
                            </div>
                            <div class="row">
                                <p class="col-4 fw-bold text-dark mb-0">Hari</p>
                                <p class="col fw-bold text-dark mb-0">: <span
                                        class="ms-1 col fw-light text-second">{{ $hari }}</span>
                                </p>
                            </div>
                            <div class="row">
                                <p class="col-4 fw-bold text-dark mb-0">Tanggal</p>
                                <p class="col fw-bold text-dark mb-0">: <span
                                        class="ms-1 col fw-light text-second">{{ \Carbon\Carbon::parse($pengiriman->pesanan->tanggal_pesanan)->format('d-M-Y') }}</span>
                                </p>
                            </div>
                            <div class="row">
                                <p class="col-4 fw-bold text-dark mb-0">Sopir</p>
                                <p class="col fw-bold text-dark mb-0">: <span
                                        class="ms-1 col fw-light text-second">{{ $pengiriman->sopir->nama ?? 'Belum Dikirim' }}</span>
                                </p>
                            </div>
                            <div class="row">
                                <p class="col-4 fw-bold text-dark mb-0">Nopol Mobil</p>
                                <p class="col fw-bold text-dark mb-0">: <span
                                        class="ms-1 col fw-light text-second">{{ $pengiriman->mobil->nopol_mobil ?? 'Belum Dikirim' }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="mb-3 col-md-5">
                            <div class="row">
                                <p class="col-3 fw-bold text-dark mb-0">Pelanggan</p>
                                <p class="col fw-bold text-dark mb-0">: <span
                                        class="ms-1 col fw-light text-second">{{ $pengiriman->pesanan->transaksi->pelanggan->nama_pemilik }}
                                        / {{ $pengiriman->pesanan->transaksi->pelanggan->nama_perusahaan }}</span>
                                </p>
                            </div>
                            <div class="row">
                                <p class="col-3 fw-bold text-dark mb-0">Email</p>
                                <p class="col fw-bold text-dark mb-0">: <span
                                        class="ms-1 col fw-light text-second">{{ $pengiriman->pesanan->transaksi->pelanggan->email }}
                                        </< /span>
                                </p>
                            </div>
                            <div class="row">
                                <p class="col-3 fw-bold text-dark mb-0">No Hp</p>
                                <p class="col fw-bold text-dark mb-0">: <span
                                        class="ms-1 col fw-light text-second">{{ $pengiriman->pesanan->transaksi->pelanggan->no_hp }}</span>
                                </p>
                            </div>
                            <div class="row">
                                <p class="col-3 fw-bold text-dark mb-0">Alamat</p>
                                <p class="col fw-bold text-dark mb-0">: <span
                                        class="ms-1 col fw-light text-second">{{ $pengiriman->pesanan->transaksi->pelanggan->alamat }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Perhitungan --}}
                    <div class="row mx-2">
                        <div class="border rounded col mt-2 p-3">
                            {{-- Rumus Standar --}}
                            <div>
                                <form id="auto-submit-form"
                                    action="{{ url('/pembelian/more/pesanan/pengiriman/' . $pengiriman->id_pengiriman . '/hitung_m3') }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <h6>Input Data of Gas Spesification and Actual P-V-T <span
                                            class="text-sm text-dark text-light opacity-7"> ( Hitung ulang ketika mengganti
                                            salah satu data ! )</span></h6>
                                    <div class="row mb-4">
                                        <div class="col-md-2">
                                            <label class="form-label">Specific Gravity <span
                                                    style="color: red">*</span></label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="spesific_gravity"
                                                    value="{{ $pengiriman->pesanan->spesific_gravity ?? 0.75 }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">CO2 <span style="color: red">*</span></label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" step="0.01" class="form-control" name="CO2"
                                                    value="{{ $pengiriman->pesanan->CO2 ?? 1.0 }}" required>
                                                <span class="input-group-text m-0 p-0 me-3 mt-2 opacity-5">%</span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">N2 <span style="color: red">*</span></label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" step="0.01" class="form-control" name="N2"
                                                    value="{{ $pengiriman->pesanan->N2 ?? 1.0 }}" required>
                                                <span class="input-group-text m-0 p-0 me-3 mt-2 opacity-5">%</span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Heating Value <span
                                                    style="color: red">*</span></label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" step="0.00001" class="form-control"
                                                    name="heating_value"
                                                    value="{{ $pengiriman->pesanan->heating_value ?? 1001.48361 }}"
                                                    required>
                                                <span class="input-group-text m-0 p-0 me-2 mt-2 opacity-5">BTU / SCF</span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Temperature <span
                                                    style="color: red">*</span></label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="temperature"
                                                    value="{{ $pengiriman->pesanan->temperature ?? 21 }}" required>
                                                <span
                                                    class="input-group-text m-0 p-0 me-3 mt-2 opacity-5"><sup>o</sup>C</span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Tube Volume <span
                                                    style="color: red">*</span></label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="tube_volume"
                                                    value="{{ $pengiriman->pesanan->tube_volume ?? 1450 }}" required>
                                                <span class="input-group-text m-0 p-0 me-3 mt-2 opacity-5">liter</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form
                                    action="{{ url('/pembelian/more/pesanan/pengiriman/' . $pengiriman->id_pengiriman . '/hitung_harga') }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <h6>Tekanan</h6>
                                    <div class="row mb-4">
                                        <div class="col-md-2"">
                                            <label class="form-label">Gas Masuk <span style="color: red">*</span></label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" class="form-control" name="gas_masuk"
                                                    value="{{ $pengiriman->kapasitas_gas_masuk ?? 0 }}" required>
                                                <span class="input-group-text m-0 p-0 me-3 mt-2 opacity-5">bar</span>
                                            </div>
                                        </div>
                                        <div class="col-md-2"">
                                            <label class="form-label">Gas Akhir <span style="color: red">*</span></label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" class="form-control" name="sisa_gas"
                                                    value="{{ $pengiriman->sisa_gas ?? 0 }}" required>
                                                <span class="input-group-text m-0 p-0 me-3 mt-2 opacity-5">bar</span>
                                            </div>
                                        </div>
                                        <div class="col-md-2"">
                                            <label class="form-label">Selisih Gas</label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" class="form-control" name="gas_keluar"
                                                    value="{{ $pengiriman->kapasitas_gas_keluar ?? 0 }}" readonly>
                                                <span class="input-group-text m-0 p-0 me-3 mt-2 opacity-5">bar</span>
                                            </div>
                                        </div>
                                        <div class="col-md-auto d-flex align-items-end">
                                            {{-- Fitur foto haru ada semua --}}
                                            @if (is_null($pengiriman->bukti_nota_pengisian) ||
                                                    is_null($pengiriman->bukti_nota_sopir) ||
                                                    is_null($pengiriman->bukti_gas_masuk) ||
                                                    is_null($pengiriman->bukti_gas_keluar))
                                                <button class="btn btn-icon btn-3 btn-primary m-0" type="submit"
                                                    disabled>
                                                    <span class="btn-inner--icon">+</span>
                                                    <span class="btn-inner--text">Hitung</span>
                                                </button>
                                            @else
                                                <button class="btn btn-icon btn-3 btn-primary m-0" type="submit">
                                                    <span class="btn-inner--icon">+</span>
                                                    <span class="btn-inner--text">Hitung</span>
                                                </button>
                                            @endif

                                            {{-- <button class="btn btn-icon btn-3 btn-primary m-0" type="submit">
                                                <span class="btn-inner--icon">+</span>
                                                <span class="btn-inner--text">Hitung</span>
                                            </button> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                            {{-- Harga Gas --}}
                            <h6>Harga Pesanan</h6>
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <label class="form-label">Volume LWC/m<sup>3</sup></label>
                                    <div class="input-group input-group-outline">
                                        <input type="number" class="form-control" name="jumlah_m3"
                                            value="{{ $pengiriman->pesanan->jumlah_m3 ?? 0 }}" readonly>
                                        <span class="input-group-text m-0 p-0 me-3 mt-2 opacity-5">m<sup>3</sup></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label"></label>
                                    <div class="input-group row text-center">
                                        <p class="col-1 mt-3">x</p>
                                        <p class="col-5 mt-3">Rp
                                            {{ number_format($pengiriman->pesanan->transaksi->pelanggan->harga_pelanggan, 0, ',', '.') }}
                                        </p>
                                        <p class="col-1 mt-3">=</p>
                                        <p class="col-5 mt-3"><strong>Rp
                                                {{ number_format($pengiriman->pesanan->harga_pesanan, 0, ',', '.') }}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bukti --}}
                    <div class="row mx-2">
                        <div class="border rounded col mt-2 p-3">
                            <div class="row mb-4">
                                <div class="col-6">
                                    <h6>Bukti Nota Pengisian</h6>
                                    @if ($pengiriman->bukti_nota_pengisian == null)
                                        <div class="d-flex justify-content-center align-items-center w-100 rounded text-center"
                                            style="background-color: #dee2e6; height: 50vh;">
                                            <p class="text-white">Belum ada bukti</p>
                                        </div>
                                    @else
                                        <div class="d-flex rounded justify-content-center align-items-center w-100"
                                            style="height: 50vh; background-color: #dee2e6;">
                                            <img src="{{ asset('img/NotaPengisian/' . $pengiriman->bukti_nota_pengisian) }}"
                                                class="img-fluid" style="max-height: 100%; object-fit: contain;"
                                                alt="Bukti Nota Pengisian">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <h6>Bukti Nota Sopir</h6>
                                    @if ($pengiriman->bukti_nota_sopir == null)
                                        <div class="d-flex justify-content-center align-items-center w-100 rounded text-center"
                                            style="background-color: #dee2e6; height: 50vh;">
                                            <p class="text-white">Belum ada bukti</p>
                                        </div>
                                    @else
                                        <div class="d-flex rounded justify-content-center align-items-center w-100"
                                            style="height: 50vh; background-color: #dee2e6;">
                                            <img src="{{ asset('img/NotaSopir/' . $pengiriman->bukti_nota_sopir) }}"
                                                class="img-fluid" style="max-height: 100%; object-fit: contain;"
                                                alt="Bukti Nota Sopir">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <h6>Bukti Gas Masuk</h6>
                                    @if ($pengiriman->bukti_gas_masuk == null)
                                        <div class="d-flex justify-content-center align-items-center w-100 rounded text-center"
                                            style="background-color: #dee2e6; height: 50vh;">
                                            <p class="text-white">Belum ada bukti</p>
                                        </div>
                                    @else
                                        <div class="d-flex rounded justify-content-center align-items-center w-100"
                                            style="height: 50vh; background-color: #dee2e6;">
                                            <img src="{{ asset('img/GasMasuk/' . $pengiriman->bukti_gas_masuk) }}"
                                                class="img-fluid" style="max-height: 100%; object-fit: contain;"
                                                alt="Bukti Gas Masuk">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <h6>Bukti Gas Keluar</h6>
                                    @if ($pengiriman->bukti_gas_keluar == null)
                                        <div class="d-flex justify-content-center align-items-center w-100 rounded text-center"
                                            style="background-color: #dee2e6; height: 50vh;">
                                            <p class="text-white">Belum ada bukti</p>
                                        </div>
                                    @else
                                        <div class="d-flex rounded justify-content-center align-items-center w-100"
                                            style="height: 50vh; background-color: #dee2e6;">
                                            <img src="{{ asset('img/GasKeluar/' . $pengiriman->bukti_gas_keluar) }}"
                                                class="img-fluid" style="max-height: 100%; object-fit: contain;"
                                                alt="Bukti Gas Keluar">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        // Automatically submit the form on input change
        document.querySelectorAll('#auto-submit-form input').forEach(function(input) {
            input.addEventListener('change', function() {
                document.getElementById('auto-submit-form').submit();
            });
        });
    </script>
@endsection
