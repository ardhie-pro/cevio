<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Auth Pages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f6f8fb;
            font-family: Inter, system-ui;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            padding: 2rem;
            border-radius: .8rem;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .06);
        }
    </style>
</head>

<body>

    <!-- LOGIN PAGE -->
    <div class="auth-card" id="login">
        <h4 class="mb-3 text-center mb-5">Masuk</h4>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" value="{{ old('email') }}" placeholder="Masukkan email" required autofocus />
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" placeholder="Masukkan password" required />

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
                <a href="#" class="small text-decoration-none">Lupa password?</a>
            </div>

            <button class="btn btn-primary w-100 mb-3" type="submit">Masuk</button>

            {{-- <div class="text-center small">
                Belum punya akun?
                <a href="#register" onclick="switchTo('register')">Daftar</a>
            </div> --}}
        </form>
    </div>

    <!-- REGISTER PAGE -->
    <div class="auth-card d-none" id="register">
        <h4 class="mb-3">Daftar Akun</h4>

        <form>
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" placeholder="Nama kamu">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="email@example.com">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" placeholder="••••••••">
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" placeholder="••••••••">
            </div>

            <button class="btn btn-primary w-100 mb-3">Daftar</button>

            <div class="text-center small">
                Sudah punya akun?
                <a href="#login" onclick="switchTo('login')">Masuk</a>
            </div>
        </form>
    </div>

    <script>
        function switchTo(id) {
            document.getElementById('login').classList.add('d-none');
            document.getElementById('register').classList.add('d-none');
            document.getElementById(id).classList.remove('d-none');
        }
    </script>
</body>

</html>
