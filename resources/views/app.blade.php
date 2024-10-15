<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('../assets/img/local/logo1.png') }}">
    <title>GasTrack admin | @yield('title', $title)</title>
    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.2/css/all.css">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    {{-- Commented because it make the app lagging --}}
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
     --}}
    <link rel="stylesheet" href="{{ asset('assets/css/material-symbols-outlined-font.css')}}" />

    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.1.0') }}" rel="stylesheet" />
    <!-- Js -->
    <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <!--<script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>-->
    @vite('resources/css/app.css')
</head>

<body class="g-sidenav-show  bg-gray-200">
    @yield('sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @yield('navbar')
        <div class="container-fluid py-4 pe-3">
            {{-- Notifikasi --}}
            @if (Auth::check())
                <div class="position-fixed top-2 end-1 d-flex flex-column" style="z-index: 100;" id="container_notif">
                    <div class="toast fade show p-2 bg-white mb-2" role="alert" style="display: none;"
                        aria-live="assertive" id="pesanan_baru" aria-atomic="true">
                        <div class="toast-header border-0">
                            <i class="material-icons text-primary me-2">inventory</i>
                            <span class="me-auto font-weight-bold">Pesanan Masuk!</span>
                            <i class="material-icons text-sm text-secondary me-1">schedule</i>
                            <small class="text-body">sekarang</small>
                            <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast"
                                aria-label="Close"></i>
                        </div>
                        <hr class="horizontal dark m-0">
                        <div class="toast-body">
                            <p class="text-sm text-secondary">
                                Pesanan dari
                                <span class="text-primary" id="nama_perusahaan_1"></span>
                            </p>
                        </div>
                    </div>
                    <div class="toast fade show p-2 bg-white mb-2" role="alert" style="display: none;"
                        aria-live="assertive" id="tagihan_dibayar" aria-atomic="true">
                        <div class="toast-header border-0">
                            <i class="material-icons text-info me-2">monetization_on</i>
                            <span class="me-auto font-weight-bold">Pesanan Dibayar!</span>
                            <i class="material-icons text-sm text-secondary me-1">schedule</i>
                            <small class="text-body">sekarang</small>
                            <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast"
                                aria-label="Close"></i>
                        </div>
                        <hr class="horizontal dark m-0">
                        <div class="toast-body">
                            <p class="text-sm text-secondary">
                                Tagihan dari
                                <span class="text-info" id="nama_perusahaan_2"></span>
                                telah dibayar
                            </p>
                        </div>
                    </div>
                    <div class="toast fade show p-2 bg-white mb-2" role="alert" style="display: none;"
                        aria-live="assertive" id="pesanan_diterima" aria-atomic="true">
                        <div class="toast-header border-0">
                            <i class="material-symbols-outlined text-warning me-2">deployed_code_account</i>
                            <span class="me-auto font-weight-bold">Pesanan Diterima!</span>
                            <i class="material-icons text-sm text-secondary me-1">schedule</i>
                            <small class="text-body">sekarang</small>
                            <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast"
                                aria-label="Close"></i>
                        </div>
                        <hr class="horizontal dark m-0">
                        <div class="toast-body">
                            <p class="text-sm text-secondary">
                                Pesanan telah diterima oleh
                                <span class="text-warning" id="nama_perusahaan_3"></span>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="position-fixed top-2 end-1 d-flex flex-column" style="z-index: 100;">
                @if (session('success'))
                    <div class="toast fade show p-2 bg-white mb-2" role="alert" aria-live="assertive"
                        id="successToast" aria-atomic="true">
                        <div class="toast-header border-0">
                            <i class="material-icons text-success me-2">check</i>
                            <span class="me-auto font-weight-bold">Success!</span>
                            <i class="material-icons text-sm text-secondary me-1">schedule</i>
                            <small class="text-body">sekarang</small>
                            <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast"
                                aria-label="Close"></i>
                        </div>
                        <hr class="horizontal dark m-0">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="toast fade show p-2 bg-white mb-2" role="alert" aria-live="assertive"
                        id="dangerToast" aria-atomic="true">
                        <div class="toast-header border-0">
                            <i class="material-icons text-danger me-2">campaign</i>
                            <span class="me-auto text-gradient text-danger font-weight-bold">Peringatan !</span>
                            <i class="material-icons text-sm text-secondary me-1">schedule</i>
                            <small class="text-body">sekarang</small>
                            <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast"
                                aria-label="Close"></i>
                        </div>
                        <hr class="horizontal dark m-0">
                        <div class="toast-body">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $err)
                        <div class="toast fade show p-2 bg-white mb-2" role="alert" aria-live="assertive"
                            id="dangerToast" aria-atomic="true">
                            <div class="toast-header border-0">
                                <i class="material-icons text-danger me-2">campaign</i>
                                <span class="me-auto text-gradient text-danger font-weight-bold">Peringatan !</span>
                                <i class="material-icons text-sm text-secondary me-1">schedule</i>
                                <small class="text-body">sekarang</small>
                                <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast"
                                    aria-label="Close"></i>
                            </div>
                            <hr class="horizontal dark m-0">
                            <div class="toast-body">
                                {{ $err }}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            @yield('content')
            <footer class="footer py-4  ">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="copyright text-center text-sm text-muted text-lg-start">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>
                                | GasTrack Team
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted"
                                        target="_blank">About Us</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/blog" class="nav-link text-muted"
                                        target="_blank">Blog</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted"
                                        target="_blank">License</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>
    {{-- Button setting --}}
    {{-- <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="material-icons py-2">settings</i>
        </a>
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">GasTrack UI Configurator</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="material-icons">clear</i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0">
                <!-- Navbar Fixed -->
                <div class="mt-3 d-flex">
                    <h6 class="mb-0">Navbar Fixed</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                            onclick="navbarFixed(this)">
                    </div>
                </div>
                <hr class="horizontal dark my-3">
                <div class="mt-2 d-flex">
                    <h6 class="mb-0">Light / Dark</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version"
                            onclick="darkMode(this)">
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Core JS Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    @vite('resources/js/app.js')
    @yield('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dangerToastElement = document.getElementById('dangerToast');
            if (dangerToastElement) {
                function hideDangerToast() {
                    var bsDangerToast = new bootstrap.Toast(dangerToastElement);
                    bsDangerToast.hide();
                }
                setTimeout(hideDangerToast, 2000);
            }

            var successToastElement = document.getElementById('successToast');
            if (successToastElement) {
                function hideSuccessToast() {
                    var bsSuccessToast = new bootstrap.Toast(successToastElement);
                    bsSuccessToast.hide();
                }
                setTimeout(hideSuccessToast, 2000);
            }

            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        });

        // Notif pesanan masuk
        function pesananMasukElement(namaPerusahaan) {
            // Buat elemen toast baru
            const newToast = document.createElement('div');
            newToast.className = 'toast fade show p-2 bg-white mb-2';
            newToast.role = 'alert';
            newToast.style.display = 'none';
            newToast.setAttribute('aria-live', 'assertive');
            newToast.id = 'pesanan_baru';
            newToast.setAttribute('aria-atomic', 'true');

            // Header toast
            const header = document.createElement('div');
            header.className = 'toast-header border-0';

            const iconInventory = document.createElement('i');
            iconInventory.className = 'material-icons text-primary me-2';
            iconInventory.textContent = 'inventory';

            const title = document.createElement('span');
            title.className = 'me-auto font-weight-bold';
            title.textContent = 'Pesanan Masuk!';

            const iconSchedule = document.createElement('i');
            iconSchedule.className = 'material-icons text-sm text-secondary me-1';
            iconSchedule.textContent = 'schedule';

            const time = document.createElement('small');
            time.className = 'text-body';
            time.textContent = 'sekarang';

            const closeButton = document.createElement('i');
            closeButton.className = 'fas fa-times text-md ms-3 cursor-pointer';
            closeButton.setAttribute('data-bs-dismiss', 'toast');
            closeButton.setAttribute('aria-label', 'Close');
            closeButton.addEventListener('click', () => newToast.style.display = 'none');

            header.appendChild(iconInventory);
            header.appendChild(title);
            header.appendChild(iconSchedule);
            header.appendChild(time);
            header.appendChild(closeButton);

            // Garis pemisah
            const hr = document.createElement('hr');
            hr.className = 'horizontal dark m-0';

            // Body toast
            const body = document.createElement('div');
            body.className = 'toast-body';

            const paragraph = document.createElement('p');
            paragraph.className = 'text-sm text-secondary';
            paragraph.textContent = 'Pesanan dari ';

            const companyName = document.createElement('span');
            companyName.className = 'text-primary';
            companyName.id = 'nama_perusahaan_1';
            companyName.textContent = namaPerusahaan;

            paragraph.appendChild(companyName);
            body.appendChild(paragraph);

            // Gabungkan semua elemen
            newToast.appendChild(header);
            newToast.appendChild(hr);
            newToast.appendChild(body);

            return newToast;
        }

        // Notif pembayaran tagihan
        function tagihanDibayarElement(namaPerusahaan) {
            // Buat elemen toast baru
            const newToast = document.createElement('div');
            newToast.className = 'toast fade show p-2 bg-white mb-2';
            newToast.role = 'alert';
            newToast.style.display = 'none';
            newToast.setAttribute('aria-live', 'assertive');
            newToast.id = 'pesanan_baru';
            newToast.setAttribute('aria-atomic', 'true');

            // Header toast
            const header = document.createElement('div');
            header.className = 'toast-header border-0';

            const iconInventory = document.createElement('i');
            iconInventory.className = 'material-icons text-info me-2';
            iconInventory.textContent = 'monetization_on';

            const title = document.createElement('span');
            title.className = 'me-auto font-weight-bold';
            title.textContent = 'Pesanan Dibayar!';

            const iconSchedule = document.createElement('i');
            iconSchedule.className = 'material-icons text-sm text-secondary me-1';
            iconSchedule.textContent = 'schedule';

            const time = document.createElement('small');
            time.className = 'text-body';
            time.textContent = 'sekarang';

            const closeButton = document.createElement('i');
            closeButton.className = 'fas fa-times text-md ms-3 cursor-pointer';
            closeButton.setAttribute('data-bs-dismiss', 'toast');
            closeButton.setAttribute('aria-label', 'Close');
            closeButton.addEventListener('click', () => newToast.style.display = 'none');

            header.appendChild(iconInventory);
            header.appendChild(title);
            header.appendChild(iconSchedule);
            header.appendChild(time);
            header.appendChild(closeButton);

            // Garis pemisah
            const hr = document.createElement('hr');
            hr.className = 'horizontal dark m-0';

            // Body toast
            const body = document.createElement('div');
            body.className = 'toast-body';

            const paragraph = document.createElement('p');
            paragraph.className = 'text-sm text-secondary';

            const companyName = document.createElement('span');
            companyName.className = 'text-info';
            companyName.id = 'nama_perusahaan_2';
            companyName.textContent = namaPerusahaan;

            paragraph.appendChild(document.createTextNode('Tagihan dari '));
            paragraph.appendChild(companyName);
            paragraph.appendChild(document.createTextNode(' telah dibayar'));

            body.appendChild(paragraph);

            // Gabungkan semua elemen
            newToast.appendChild(header);
            newToast.appendChild(hr);
            newToast.appendChild(body);

            return newToast;
        }

        // Notif pesanan diterima
        function pesananDiterimaElement(namaPerusahaan) {
            // Buat elemen toast baru
            const newToast = document.createElement('div');
            newToast.className = 'toast fade show p-2 bg-white mb-2';
            newToast.role = 'alert';
            newToast.style.display = 'none';
            newToast.setAttribute('aria-live', 'assertive');
            newToast.id = 'pesanan_diterima';
            newToast.setAttribute('aria-atomic', 'true');

            // Header toast
            const header = document.createElement('div');
            header.className = 'toast-header border-0';

            const iconCode = document.createElement('i');
            iconCode.className = 'material-symbols-outlined text-warning me-2';
            iconCode.textContent = 'deployed_code_account';

            const title = document.createElement('span');
            title.className = 'me-auto font-weight-bold';
            title.textContent = 'Pesanan Diterima!';

            const iconSchedule = document.createElement('i');
            iconSchedule.className = 'material-icons text-sm text-secondary me-1';
            iconSchedule.textContent = 'schedule';

            const time = document.createElement('small');
            time.className = 'text-body';
            time.textContent = 'sekarang';

            const closeButton = document.createElement('i');
            closeButton.className = 'fas fa-times text-md ms-3 cursor-pointer';
            closeButton.setAttribute('data-bs-dismiss', 'toast');
            closeButton.setAttribute('aria-label', 'Close');
            closeButton.addEventListener('click', () => newToast.style.display = 'none');

            header.appendChild(iconCode);
            header.appendChild(title);
            header.appendChild(iconSchedule);
            header.appendChild(time);
            header.appendChild(closeButton);

            // Garis pemisah
            const hr = document.createElement('hr');
            hr.className = 'horizontal dark m-0';

            // Body toast
            const body = document.createElement('div');
            body.className = 'toast-body';

            const paragraph = document.createElement('p');
            paragraph.className = 'text-sm text-secondary';

            const companyName = document.createElement('span');
            companyName.className = 'text-warning';
            companyName.id = 'nama_perusahaan_3';
            companyName.textContent = namaPerusahaan;

            paragraph.appendChild(document.createTextNode('Pesanan telah diterima oleh '));
            paragraph.appendChild(companyName);

            body.appendChild(paragraph);

            // Gabungkan semua elemen
            newToast.appendChild(header);
            newToast.appendChild(hr);
            newToast.appendChild(body);

            return newToast;
        }

        // Event listener
        document.addEventListener("DOMContentLoaded", function(event) {
            Echo.channel(`PesananBaru-channel`).listen('PesananBaruEvent', (e) => {
                const container = document.getElementById('container_notif');
                const newToast = pesananMasukElement(e.nama_perusahaan);

                // Tambahkan elemen toast baru ke dalam container
                container.appendChild(newToast);
                newToast.style.display = 'block';
            });

            Echo.channel(`BayarTagihan-channel`).listen('BayarTagihanEvent', (e) => {
                const container = document.getElementById('container_notif');
                const newToast = tagihanDibayarElement(e.nama_perusahaan);

                // Tambahkan elemen toast baru ke dalam container
                container.appendChild(newToast);
                newToast.style.display = 'block';
            });

            Echo.channel(`GasKeluar-channel`).listen('GasKeluarEvent', (e) => {
                const container = document.getElementById('container_notif');
                const newToast = pesananDiterimaElement(e.nama_perusahaan);

                // Tambahkan elemen toast baru ke dalam container
                container.appendChild(newToast);
                newToast.style.display = 'block';
            });
        });
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.1.0') }}"></script>
</body>

</html>
