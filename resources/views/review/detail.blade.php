@extends('layouts.main')

@section('title', 'Detail Soal')

@section('content')
    <div class="container mt-4">
        <h4 class="fw-bold mb-3">🧠 Soal untuk Modul: {{ $modul }}</h4>

        <div class="card">
            <div class="card-body">
                <p>{!! $soal->soal ?? 'Belum ada soal untuk modul ini.' !!}</p>
            </div>
        </div>

        <a href="{{ route('review.show', $kode) }}" class="btn btn-secondary mt-3">← Kembali ke Modul</a>
    </div>
@endsection
