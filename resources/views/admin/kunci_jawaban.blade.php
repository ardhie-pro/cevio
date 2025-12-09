@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        .td-soal {
            max-width: 350px;
            /* batas kolom soal */
            white-space: normal;
            /* izinkan turun baris */
            word-break: break-word;
            /* pecah kata panjang */
        }

        .td-soal img {
            max-width: 100%;
            height: auto;
            display: block;
            margin-top: 5px;
        }
    </style>
    <br>
    <br>

    <br>

    <br>

    <br>

    <br>

    <br>

    <br>


    <div class="container mt-4">
        <h4 class="mb-3">
            <i class="mdi mdi-key-variant"></i>
            Kunci Jawaban - {{ $modul }} ({{ ucfirst($type_template) }})
        </h4>

        <form action="{{ route('kunci-jawaban.simpan') }}" method="POST">
            @csrf

            {{-- Modul otomatis --}}
            <input type="hidden" name="modul_jawaban" value="{{ $modul }}">

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Soal</th>
                            <th>Kunci</th>
                            <th>Poin</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $row->no }}</td>

                                <!-- Kolom soal (responsif + wrap + base64 image fix) -->
                                <td class="td-soal">
                                    {!! $row->soal !!}
                                </td>

                                <td>
                                    <select class="form-select form-select-sm" name="jawaban_benar[{{ $row->no }}]">
                                        <option value="">Pilih</option>

                                        @foreach (['A', 'B', 'C', 'D', 'E'] as $opsi)
                                            <option value="{{ $opsi }}"
                                                {{ isset($kunci[$row->no]) && $kunci[$row->no]->jawaban_benar == $opsi ? 'selected' : '' }}>
                                                {{ $opsi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <input type="text" class="form-control form-control-sm"
                                        name="poin_jawaban[{{ $row->no }}]"
                                        value="{{ $existingPoin[$row->no] ?? '' }}" placeholder="cth: 10">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>



            <button type="submit" class="btn btn-success" style="margin-bottom: 100px">
                <i class="mdi mdi-content-save-outline"></i> Simpan Kunci Jawaban
            </button>

        </form>


    </div>
@endsection
