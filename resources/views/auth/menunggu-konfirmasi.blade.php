@extends('layouts.main')

@section('title', 'Menunggu Konfirmasi')

@section('content')
<div class="page-content">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card text-center shadow-lg p-4" style="max-width: 500px;">
            <h4 class="mb-3 text-warning">⏳ Mohon Tunggu Konfirmasi</h4>
            <p class="mb-4">
                Akun Anda sedang menunggu konfirmasi dari admin.  
                Jika Anda membutuhkan akses segera, silakan hubungi kami.
            </p>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    <i class="mdi mdi-logout"></i> Kembali
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
