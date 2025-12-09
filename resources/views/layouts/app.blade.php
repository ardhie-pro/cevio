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
    {{-- Jika kamu pakai Bosstrab custom, aktifkan ini --}}
    {{-- <link href="{{ asset('css/bosstrab.css') }}" rel="stylesheet"> --}}

    <!-- ✅ Vite Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="font-family: 'Inter', sans-serif; background-color: #f8f9fa;">
    {{-- ✅ Navbar --}}
    @include('layouts.navigation')

    {{-- ✅ Page Header --}}
    @isset($header)
        <header class="bg-white shadow-sm border-bottom mb-3">
            <div class="container py-3">
                <h4 class="m-0">{{ $header }}</h4>
            </div>
        </header>
    @endisset

    {{-- ✅ Main Content --}}
    <main class="container py-4">
        {{ $slot }}
    </main>

    {{-- ✅ Bootstrap / Bosstrab JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
