<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>CIBN | Citta Bhakti Nirbaya </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assetts/images/favicon.ico') }}" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assetts/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assetts/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assetts/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body data-topbar="colored">
    <!-- <body data-layout="horizontal" data-topbar="colored"> -->

    <!-- Background -->
    <div class="account-pages"></div>
    <!-- Begin page -->
    <div class="wrapper-page">
        <div class="card">
            <div class="card-body">
                <div class="auth-logo">
                    <h3 class="text-center">
                        <a href="index.html" class="logo d-block my-4">
                            <img src="{{ asset('assetts/images/logo-sm-dark.png') }}" class="logo-dark mx-auto"
                                height="150" alt="logo-dark" />
                            <img src="{{ asset('assetts/images/logo-light.png') }}" class="logo-light mx-auto"
                                height="30" alt="logo-light" />
                        </a>
                    </h3>
                </div>

                <div class="p-3 text-center">
                    <h4 class="text-muted font-size-18">Anda telah mengerjakan semua subtest</h4>
                    <p class="text-muted">
                        Anda akan otomatis keluar dan kembali ke halaman utama dalam <span id="countdown">10</span>
                        detik.
                    </p>

                    <div class="spinner-border text-primary mt-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <script>
                    let seconds = 10;
                    const countdown = document.getElementById("countdown");

                    const timer = setInterval(() => {
                        seconds--;
                        countdown.textContent = seconds;
                        if (seconds <= 0) {
                            clearInterval(timer);
                            // Arahkan ke logouttest route untuk destroy session ujian
                            window.location.href = "{{ route('logouttest') }}";
                        }
                    }, 1000);
                </script>

                <script>
                    let seconds = 10;
                    const countdown = document.getElementById("countdown");

                    const timer = setInterval(() => {
                        seconds--;
                        countdown.textContent = seconds;
                        if (seconds <= 0) {
                            clearInterval(timer);
                            // Arahkan ke logout route untuk destroy session
                            window.location.href = "{{ route('logout') }}";
                        }
                    }, 1000);
                </script>
            </div>
        </div>

        <div class="text-center">
            
            <p class="text-muted">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                CIBN. Crafted with Citta Bhakti Nirbaya
            </p>
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title px-3 py-4">
                <a href="javascript:void(0);" class="right-bar-toggle float-end">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
                <h5 class="m-0">Settings</h5>
            </div>

            <!-- Settings -->
            <hr class="" />
            <h6 class="text-center mb-0">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="{{ asset('assetts/images/layouts/layout-1.png') }}" class="img-fluid img-thumbnail"
                        alt="" />
                </div>

                <div class="form-check form-switch mb-3">
                    <input type="checkbox" class="form-check-input theme-choice" id="light-mode-switch" checked />
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('assetts/images/layouts/layout-2.png') }}" class="img-fluid img-thumbnail"
                        alt="" />
                </div>

                <div class="form-check form-switch mb-3">
                    <input type="checkbox" class="form-check-input theme-choice" id="dark-mode-switch"
                        data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css" />
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('assetts/images/layouts/layout-3.png') }}" class="img-fluid img-thumbnail"
                        alt="" />
                </div>
                <div class="form-check form-switch mb-5">
                    <input type="checkbox" class="form-check-input theme-choice" id="rtl-mode-switch"
                        data-appStyle="assets/css/app-rtl.min.css" />
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>

                <h6 class="mb-2">Select Custom Colors</h6>

                <div class="form-check form-check-inline">
                    <input class="form-check-input theme-color" type="radio" name="theme-mode" id="theme-default"
                        value="default" onchange="document.documentElement.setAttribute('data-theme-mode', 'default')"
                        checked />
                    <label class="form-check-label" for="theme-default">Default</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input theme-color" type="radio" name="theme-mode" id="theme-red"
                        value="red" onchange="document.documentElement.setAttribute('data-theme-mode', 'red')" />
                    <label class="form-check-label" for="theme-red">Red</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input theme-color" type="radio" name="theme-mode" id="theme-green"
                        value="green" onchange="document.documentElement.setAttribute('data-theme-mode', 'green')" />
                    <label class="form-check-label" for="theme-green">Green</label>
                </div>
            </div>
        </div>
        <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assetts/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assetts/js/app.js') }}"></script>
</body>

</html>
