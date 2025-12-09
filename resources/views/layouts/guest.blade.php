<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- ✅ Bootstrap / Bosstrab CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Jika kamu punya bosstrab.css custom, aktifkan baris di bawah ini --}}
    {{-- <link href="{{ asset('css/bosstrab.css') }}" rel="stylesheet"> --}}

    <!-- ✅ Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="font-family: 'Inter', sans-serif; background-color: #f8f9fa;">
    <div class="d-flex flex-column min-vh-100 justify-content-center align-items-center py-5">
        <div class="text-center mb-4">
            <a href="/">
                <x-application-logo class="text-secondary" style="width:80px; height:80px;" />
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-4" style="width: 100%; max-width: 420px;">
            <div class="card-body p-4">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- ✅ Bootstrap / Bosstrab JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
