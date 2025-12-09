@extends('layouts.main')

@section('title', 'Daftar Modul')

@section('content')
    <div class="container mt-4">
        <h4 class="fw-bold mb-3">📂 Daftar Modul untuk Kode: {{ $kodeData->kode }}</h4>

        <ul class="list-group">
            @forelse ($modulList as $m)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $m }}
                    <a href="{{ route('review.detail', ['kode' => $kodeData->kode, 'modul' => $m]) }}"
                        class="btn btn-sm btn-success">
                        Lihat Soal
                    </a>
                </li>
            @empty
                <li class="list-group-item text-muted">Tidak ada modul ditemukan.</li>
            @endforelse
        </ul>
    </div>
@endsection
