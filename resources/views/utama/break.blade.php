<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>CIBN | Citta Bhakti Nirbaya</title>
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
    <style>
        .countdown {
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body data-topbar="colored">
    <!-- <body data-layout="horizontal" data-topbar="colored"> -->

    <!-- Background -->
    <div class="account-pages"></div>
    <!-- Begin page -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <!-- Bagian Break -->
        <div id="breakSection" class="card shadow col-12 col-md-6 text-center p-4">
            <div class="card-body">
                <h3 class="mb-3">Waktu Istirahat Sebentar 😌</h3>
                <p class="lead">
                    Kamu telah menyelesaikan bagian sebelumnya.<br />
                    Silakan gunakan waktu ini untuk beristirahat sebelum lanjut ke soal
                    berikutnya.
                </p>

                <button id="timerButton" width="200" class="btn btn-danger btn-header">
                    Waktu: <span id="liveTimer">00:00:00</span>
                </button>
            </div>
        </div>

        <!-- Bagian Soal Selanjutnya -->

    </div>
    <div class="wrapper-page">
        <div class="text-center">
            <p class="text-muted">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                CIBN. Crafted with  by
                Citta Bhakti Nirbaya
            </p>
        </div>
    </div>


    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    @php
        use App\Models\Kode;
        use Carbon\Carbon;

        $kodeLogin = session('kode_login');
        $kodeData = Kode::where('kode', $kodeLogin)->first();

        // waktu selesai dari database (format waktu Jakarta)
        $waktuSelesai = $kodeData ? Carbon::parse($kodeData->waktu, 'Asia/Jakarta')->format('Y-m-d H:i:s') : null;
    @endphp
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const display = document.getElementById("liveTimer");
            if (!display) return;

            // 🕒 Ambil waktu selesai dari session (format: Y-m-d H:i:s)
            const waktuSelesaiString = "{{ $waktuSelesai }}";

            const kodeLogin = "{{ session('kode_login') }}";
            const modul = "{{ $modul }}";

            // ⏰ Parse waktu selesai (anggap format lokal Asia/Jakarta)
            const waktuSelesai = new Date(waktuSelesaiString.replace(" ", "T") + "+07:00");

            const timerInterval = setInterval(updateTimer, 1000);
            updateTimer();

            function updateTimer() {
                const now = new Date();
                const remaining = waktuSelesai - now;

                if (remaining <= 0) {
                    clearInterval(timerInterval);
                    tampilkanWaktuHabis();
                    return;
                }

                const totalSeconds = Math.floor(remaining / 1000);
                const hours = Math.floor(totalSeconds / 3600);
                const minutes = Math.floor((totalSeconds % 3600) / 60);
                const seconds = totalSeconds % 60;

                display.textContent =
                    `${hours.toString().padStart(2,"0")}:${minutes.toString().padStart(2,"0")}:${seconds.toString().padStart(2,"0")}`;
            }

            function tampilkanWaktuHabis() {
                // 🔒 cegah tombol back
                history.pushState(null, null, document.URL);
                window.onpopstate = () => history.pushState(null, null, document.URL);

                // 🌕 overlay full-screen putih
                const overlay = document.createElement("div");
                overlay.style = `
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: white;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    `;

                overlay.innerHTML = `
        <style>
            .spinner {
                position: relative;
                width: 120px;
                height: 120px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .spinner::before {
                content: "";
                position: absolute;
                width: 100px;
                height: 100px;
                border: 5px solid #ddd;
                border-top-color: #3498db;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
        </style>

        <form id="autoNextForm" action="/next-modul" method="POST">
            @csrf
            <input type="hidden" name="kodeLogin" value="${kodeLogin}">
            <input type="hidden" name="modul" value="${modul}">
            <div class="spinner">
                <img src="{{ asset('assetts/images/logo-sm-dark.png') }}" 
                     alt="logo" 
                     style="width: 60px; height: auto; z-index: 2;">
            </div>
        </form>
    `;
                document.body.appendChild(overlay);

                // ⏳ auto-submit setelah 1 detik
                setTimeout(() => {
                    document.getElementById("autoNextForm").submit();
                }, 1000);
            }
        });
    </script>
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
