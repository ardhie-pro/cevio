<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Register Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Halaman pendaftaran admin" name="description" />
    <meta content="Ardhie" name="author" />
    <link rel="shortcut icon" href="{{ asset('assetts/images/favicon.ico') }}" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assetts/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assetts/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assetts/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body data-topbar="colored">
    <div class="account-pages"></div>
    <div class="wrapper-page">
        <div class="card">
            <div class="card-body">
                <div class="auth-logo">
                    <h3 class="text-center">
                        <a href="#" class="logo d-block my-4">
                            <img src="{{ asset('assetts/images/logo-sm-dark.png') }}" class="logo-dark mx-auto"
                                height="150" alt="logo-dark" />
                            <img src="{{ asset('assetts/images/logo-light.png') }}" class="logo-light mx-auto"
                                height="30" alt="logo-light" />
                        </a>
                    </h3>
                </div>

                <div class="p-3">
                    <h4 class="text-muted font-size-18 text-center">Buat Akun Baru</h4>
                    <p class="text-muted text-center">Isi data berikut untuk mendaftar.</p>

                    {{-- Error Messages --}}
                    @props(['errors'])

                    @if ($errors->any())
                        <div {{ $attributes }}>
                            <div class="alert alert-danger">
                                <strong>Terjadi kesalahan:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif


                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label" for="name">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}"
                                placeholder="Masukkan nama lengkap" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email"
                                required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Masukkan password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Ulangi password" required>
                        </div>

                        {{-- Tombol Register --}}
                        <div class="text-end">
                            <button class="btn btn-success w-md waves-effect waves-light" type="submit">
                                Daftar Sekarang
                            </button>
                        </div>

                        <div class="mt-3 text-center">
                            <p class="text-muted mb-0">Sudah punya akun?
                                <a href="{{ route('login') }}" class="text-primary fw-semibold">Masuk di sini</a>
                            </p>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="text-center">
           
            <p class="text-muted">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                CIBN. Crafted with <i class="mdi mdi-heart text-primary"></i> by Citta Bakhti Nirbaya.
            </p>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assetts/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assetts/js/app.js') }}"></script>
</body>

</html>
