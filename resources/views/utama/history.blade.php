<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - CIBN</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background: url("{{ asset('assetts/images/weepo.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            /* biar full 1 layar */
            min-height: 100vh;
            position: relative;
            font-family: "Segoe UI", sans-serif;
        }

        /* Background Images */
        .bg-top {
            margin-top: -130px;
            position: absolute;
            top: 0;
            left: 0;
            width: 400px;
            height: auto;
            z-index: 0;
        }

        .bg-bottom {
            margin-right: -330px;
            position: absolute;
            bottom: 0;
            right: 0;
            width: 800px;
            height: auto;
            z-index: 0;
        }

        /* Login Card - GLASS EFFECT */
        .login-box {
            background: rgba(255, 255, 255, 0.094);
            /* kaca */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);

            border: 1px solid rgba(11, 75, 139, 0.196);
            /* biru transparan */
            border-radius: 15px;

            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.20);
            max-width: 700px;
            margin: 120px auto;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .login-left {
            width: 45%;
            text-align: center;
            padding: 20px;
            border-right: 5px solid rgba(0, 59, 118, 0.4);
            /* transparan agar cocok dengan efek kaca */
        }

        .login-left img {
            width: 170px;
            margin-bottom: 10px;
        }

        .login-left h5 {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
        }

        .login-right {
            width: 100%;
            padding: 30px 40px;
            background: rgba(255, 255, 255, 0);
            /* sedikit transparan */
            border-radius: 0 15px 15px 0;
            /* mengikuti bentuk card */
        }

        .login-right h4 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
            color: #333;
        }



        .form-control {
            background: rgba(255, 255, 255, 0);
            /* transparan */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);

            border: 1px solid rgba(11, 75, 139, 0.242);
            border-radius: 8px;

            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);

            color: #fff;
            /* biar tulisan tetap terlihat */
        }

        .btn-login {
            width: 100%;
            background-color: #007bff;
            color: white;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        .forgot {
            display: block;
            text-align: right;
            font-size: 12px;
            color: #007bff;
            text-decoration: none;
            margin-top: 5px;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-box {
                flex-direction: column;
                width: 90%;
            }

            .login-left {
                width: 100%;
                border-right: none;
                border-bottom: 2px solid rgba(11, 75, 139, 0.4);
            }

            .login-right {
                width: 100%;
                border-radius: 0 0 15px 15px;
            }

            .bg-top {
                margin-top: -145px;
                left: 0;
                width: 200px;
            }

            .bg-bottom {
                margin-right: -165px;
                margin-bottom: -200px;
                width: 400px;
            }
        }

        .fab-container {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 9999;
        }

        /* FAB Button tetap di posisi */
        .fab-button {
            width: 55px;
            height: 55px;
            background: #0d6efd;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 26px;
            cursor: pointer;
            position: absolute;
            bottom: 0;
            right: 0;
            transition: 0.3s;
        }

        .fab-button:hover {
            transform: scale(1.1);
        }

        /* FAB Menu harus di posisi absolute di atas tombol */
        .fab-menu {
            position: absolute;
            bottom: 70px;
            /* muncul di atas tombol */
            right: 0;
            display: none;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.25);
        }

        /* Floating Action Button */
        .fab-container {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 9999;
        }

        .fab-button {
            width: 55px;
            height: 55px;
            background: #0d6efd;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 26px;
            cursor: pointer;
            transition: 0.3s;
        }

        .fab-button:hover {
            transform: scale(1.1);
        }

        .fab-menu {
            display: none;
            margin-bottom: 10px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.25);
        }

        .fab-menu a,
        .fab-menu button {
            display: block;
            width: 150px;
            padding: 8px 12px;
            margin-bottom: 6px;
            text-decoration: none;
            background: #0d6efd;
            color: white;
            font-size: 14px;
            border-radius: 6px;
            border: none;
            text-align: center;
            cursor: pointer;
        }

        .fab-menu a:hover,
        .fab-menu button:hover {
            background: #084298;
        }

        .form-control::placeholder {
            color: #f8f9fa !important;
            opacity: 1;
        }

        body {
            background-color: #fff;
            min-height: 100vh;
            font-family: "Segoe UI", sans-serif;
            position: relative;
        }

        .bg-bottom {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 800px;
            height: auto;
            z-index: -1;
            margin-right: -330px;
        }

        .history-card {
            border: 2px solid #0b4b8b;
            border-radius: 10px;
            padding: 20px;
            background: #fff;
            transition: 0.3s;
        }

        .history-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .header-bar {
            padding: 15px 30px;
            border-bottom: 2px solid #0b4b8b;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background-color: #0b4b8b;
            border-radius: 50%;
        }

        .history-card {
            background: rgba(255, 255, 255, 0.09);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(11, 75, 139, 0.25);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            color: #fff;
            min-height: 150px;

            display: flex;
            flex-direction: column;
            justify-content: center;

            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        /* batasi 3 baris */
        .history-card p {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        /* tombol lihat laporan kecil dan rapi */
        .btn-history {
            display: block;
            margin: 10px auto 0 auto;
            width: fit-content;
        }

        .history-card a,
        .history-card a:hover,
        .history-card a:focus {
            text-decoration: none !important;
        }

        /* atau hilangkan underline untuk semua link dalam card container */
        .history-card {
            text-decoration: none !important;
        }

        a {
            text-decoration: none !important;
        }
    </style>

</head>

<body>

    <!-- CONTENT -->


    <div class="container my-5">

        <h3 class="text-center mb-4 fw-semibold text-light">Riwayat Pengerjaan Anda</h3>

        <div class="row justify-content-center">

            @forelse ($riwayat as $kodeRiwayat)
                @php
                    $kode = trim($kodeRiwayat);
                    $info = \App\Models\Kode::where('kode', $kode)->first();
                @endphp

                @if ($info)
                    <div class="col-md-4 mb-4">
                        <a href="{{ route('hasiluser.show', ['kode' => $info->kode]) }}">
                            <div class="history-card">

                                {{-- KODE --}}
                                <p class="fs-5 text-light mb-1">
                                    {{ $info->kode }}
                                </p>

                                {{-- MODUL --}}
                                <p class="text-light mb-1">
                                    Modul:
                                    @php
                                        $moduls = \App\Models\TarikModul::where('id', $info->modul_id)->pluck('modul');
                                    @endphp

                                    @forelse ($moduls as $m)
                                        <strong>{{ $m }}</strong><br>
                                    @empty
                                        <strong>-</strong>
                                    @endforelse
                                </p>


                                {{-- WAKTU --}}
                                <p class="text-light mb-0">
                                    {{ $info->created_at?->format('d M Y H:i') }}
                                </p>

                            </div>
                        </a>
                    </div>
                @endif

            @empty
                <div class="text-center text-muted">
                    Belum ada riwayat pengerjaan.
                </div>
            @endforelse


        </div>
    </div>


    <div class="fab-container">

        <!-- FAB Menu (muncul di atas tombol) -->
        <div class="fab-menu" id="fabMenu">
            <a href="{{ route('history.login') }}">📜 History</a>
            <a href="#" id="btnFabChangePw">🔑 Ganti Password</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">🚪 Logout</button>
            </form>
        </div>

        <!-- FAB Button -->
        <div class="fab-button" id="fabBtn">☰</div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('fabBtn').addEventListener('click', function() {
            let menu = document.getElementById('fabMenu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        });

        document.getElementById('btnFabChangePw').addEventListener('click', function() {
            document.getElementById('btnChangeAccount').click();
        });
    </script>
</body>

</html>
