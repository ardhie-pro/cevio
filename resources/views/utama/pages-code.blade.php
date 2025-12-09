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
    </style>
</head>

<body>
    <!-- Background Images -->
    {{-- <img src="{{ asset('assetts/images/atas.png') }}" alt="bg top" class="bg-top" />
    <img src="{{ asset('assetts/images/bawah.png') }}" alt="bg bottom" class="bg-bottom" /> --}}

    <!-- Login Box -->



    <!-- Background Images -->



    <!-- Login Box -->
    <div id="formContainer">
        <div class="login-box">
            <div class="login-right">
                <h4 class="mb-5 text-light">Masukan Kode Pengerjaan</h4>
                <button type="button" class="dropdown-item text-primary" id="btnChangeAccount">
                    <i class="bi bi-key me-2"></i>
                </button>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('kode.check') }}" id="loginForm" method="POST">
                    @csrf

                    <div class="mb-3 text-light">
                        <input type="text" name="kode" class="form-control" placeholder="Kode" />
                    </div>

                    <button type="submit" class="btn btn-login">Mulai</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Floating Action Button (FAB) -->
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


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('btnChangeAccount').addEventListener('click', function() {

            document.querySelector('.login-right h4').innerText = "Ganti Password & Akun";

            document.getElementById('formContainer').innerHTML = `
            <div class="login-box">
            <div class="login-right">
        <form action="{{ route('akun.update') }}" method="POST">
            @csrf

            <div class="mb-3">
                <input type="text" name="username" class="form-control"
                    value="{{ Auth::user()->name }}" placeholder="Username Baru" required>
            </div>

            <div class="mb-3">
                <input type="email" name="email" class="form-control"
                    value="{{ Auth::user()->email }}" placeholder="Email Baru" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password" value="{{ Auth::user()->lihatpw }}" id="pwInput" class="form-control"
                    placeholder="Password Baru" required>
            </div>

            <div class="mb-3 text-light">
                <input type="checkbox" onclick="togglePw()"> Tampilkan Password
            </div>


            <button type="submit" class="btn btn-login">Simpan Perubahan</button>
            </div>
            </div>
        </form>
    `;
        });

        function togglePw() {
            let pw = document.getElementById('pwInput');
            pw.type = pw.type === 'password' ? 'text' : 'password';
        }
    </script>
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
