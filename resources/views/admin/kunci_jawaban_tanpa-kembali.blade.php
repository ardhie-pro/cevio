@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <br><br><br><br><br><br><br><br>

    <div class="container mt-4">
        <h4 class="mb-3">
            <i class="mdi mdi-key-variant"></i>
            Kunci Jawaban (Tanpa Kembali) - {{ $modul }}
        </h4>

        {{-- 🔹 Arahkan ke route simpan-tanpa-kembali --}}
        <form action="{{ route('kunci-jawaban.simpan-tanpa-kembali') }}" method="POST">
            @csrf

            {{-- Simpan modul agar bisa dibaca ulang di controller --}}
            <input type="hidden" name="modul_jawaban" value="{{ $modul }}">

            <table class="table table-bordered align-middle">
                <thead class="table-primary">
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <th>Soal</th>
                        <th colspan="5">Poin per Pilihan</th>
                    </tr>
                    <tr class="text-center">
                        <th></th>
                        <th></th>
                        <th width="10%">A</th>
                        <th width="10%">B</th>
                        <th width="10%">C</th>
                        <th width="10%">D</th>
                        <th width="10%">E</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td class="text-center">{{ $row->no }}</td>
                            <td>{{ $row->soal }}</td>

                            @foreach (['A', 'B', 'C', 'D', 'E'] as $opsi)
                                @php
                                    // kunci format nomor_opsi misalnya "1_A"
                                    $key = $row->no . '_' . $opsi;
                                @endphp
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm text-center"
                                        name="poin_jawaban[{{ $row->no }}][{{ $opsi }}]"
                                        value="{{ old('poin_jawaban.' . $row->no . '.' . $opsi, $existingPoin[$key] ?? '') }}"
                                        placeholder="0">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end">
                <button type="submit" class="btn btn-success" style="margin-bottom: 100px">
                    <i class="mdi mdi-content-save-outline"></i> Simpan Poin Jawaban
                </button>
            </div>
        </form>
    </div>

    {{-- 🔔 Optional toastr success --}}
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                toastr.success("{{ session('success') }}");
            });
        </script>
    @endif
@endsection
