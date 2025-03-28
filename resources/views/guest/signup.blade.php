<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/local/logo1.png">
    <title>GasTrack admin | @yield('title', $title)</title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    {{-- <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script> --}}
</head>

<body class="bg-gray-200">
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('../assets/img/local/bg_login2.png');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container my-auto">
                @if (session('success'))
                    <div class="position-fixed top-2 end-1 z-index-2">
                        <div class="toast fade show p-2 bg-white" role="alert" aria-live="assertive" id="successToast" aria-atomic="true">
                            <div class="toast-header border-0">
                                <i class="material-icons text-success me-2">check</i>
                                <span class="me-auto font-weight-bold">Success!</span>
                                <small class="text-body">sekarang</small>
                                <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast" aria-label="Close"></i>
                            </div>
                            <hr class="horizontal dark m-0">
                            <div class="toast-body">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $err)
                        <div class="toast fade show p-2 mt-2 bg-white position-fixed top-2 end-1 z-index-2" role="alert" aria-live="assertive" id="dangerToast" aria-atomic="true">
                            <div class="toast-header border-0">
                                <i class="material-icons text-danger me-2">campaign</i>
                                <span class="me-auto text-gradient text-danger font-weight-bold">Peringatan !</span>
                                <small class="text-body">sekarang</small>
                                <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast" aria-label="Close"></i>
                            </div>
                            <hr class="horizontal dark m-0">
                            <div class="toast-body">
                                {{$err}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-xl py-3 pe-1  text-center">
                                    <img class="w-55 mb-0" src="{{ asset('assets/img/local/logo6.png') }}" class="navbar-brand-img" alt="main_logo">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="pb-0 text-left bg-transparent text-center">
                                    <h4 class="font-weight-bolder text-primary text-gradient">Mari Bergabung</h4>
                                    <p class="mb-0">Masukkan data anda dengan benar !</p>
                                </div>
                                <form role="form" class="text-start" method="POST" action="{{ url('signup_action') }}">
                                    @csrf
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Nama<span class="text-danger ms-1">*</label>
                                        <input type="text" class="form-control" name="nama" required>
                                    </div>
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Email<span class="text-danger ms-1">*</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Password<span class="text-danger ms-1">*</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Konfirmasi Password<span class="text-danger ms-1">*</label>
                                        <input type="password" class="form-control" name="konfirmasi_password" required>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Daftar</button>
                                    </div>
                                    <p class="mt-4 text-sm text-center">
                                        Sudah punya akun ?
                                        <a href="{{ url('/') }}"
                                            class="text-primary text-gradient font-weight-bold">Masuk</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer position-absolute bottom-2 py-2 w-100">
                <div class="container">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-12 col-md-6 my-auto">
                            <div class="copyright text-center text-sm text-white text-lg-start">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>
                                | GasTrack Team
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/presentation" class="nav-link text-white"
                                        target="_blank">About Us</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/blog" class="nav-link text-white"
                                        target="_blank">Blog</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-white"
                                        target="_blank">License</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>
    <!-- Tambahkan script untuk mengatur waktu penghilangan notifikasi -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dangerToastElement = document.getElementById('dangerToast');
            function hideDangerToast() {
                var bsDangerToast = new bootstrap.Toast(dangerToastElement);
                bsDangerToast.hide();
            }
            setTimeout(hideDangerToast, 2000);
    
            var successToastElement = document.getElementById('successToast');
            function hideSuccessToast() {
                var bsSuccessToast = new bootstrap.Toast(successToastElement);
                bsSuccessToast.hide();
            }
            setTimeout(hideSuccessToast, 2000);
        });
    </script>
</body>

</html>
