@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <style>
        body {
            background: #f4f6fb;
            padding: 0;
            font-family: "Inter", Arial, sans-serif;
        }

        .wrapper {
            border: 2px solid #cdd6e4;
            border-radius: 14px;
            padding: 25px;
            background: #fff;
            margin: 40px auto;
            width: 90%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .title {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 18px;
            background: #F4C542 !important;
            color: #0E2542 !important;
            padding: 8px 14px;
            border-radius: 8px;
            width: max-content;
        }

        /* form edit */
        .edit-box {
            padding: 20px;
            background: #f9fbff;
            border: 1px solid #d8dce5;
            border-radius: 10px;
            margin-top: 15px;
            display: none;
            animation: slide 0.2s ease-out;
        }

        @keyframes slide {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-answered {
            background-color: #244e9b;
            color: white;
        }
    </style>

    <div class="page-content">

        <div class="wrapper card card-animate mt-5">
            <div class="title mb-4">Daftar Soal -----</div>

            <button class="btn btn-answered col-2" data-bs-toggle="modal" data-bs-target="#addModal">
                Tambah Soal
            </button>

            <table id="" class="table table-striped table-bordered dt-responsive nowrap mt-3">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama Soal</th>
                        <th>Type Soal</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->modul }}</td>
                            <td>{{ $row->type_template }}</td>
                            <td>{{ $row->waktu }}</td>
                            <td>
                                {{-- === LOGIKA DISPLAY BUTTONS === --}}
                                @php
                                    $tt = strtolower(trim($row->type_template));
                                @endphp

                                {{-- 🔥 ISTIRAHAT: tidak ada tombol sama sekali --}}
                                @if ($tt === 'istirahat')
                                    {{-- nothing --}}

                                    {{-- 🔥 PANDUAN / NAMA-PESERTA: ganti Kasih Soal -> Buat Penulisan --}}
                                @elseif ($tt === 'panduan' || $tt === 'data-nama')
                                    <a href="{{ url('/soal?modul=' . urlencode($row->modul) . '&type_template=' . urlencode($row->type_template)) }}"
                                        class="btn btn-info btn-sm">
                                        Buat Penulisan
                                    </a>

                                    {{-- 🔥 TEMPLATE BIASA --}}
                                @else
                                    <a href="{{ url('/soal?modul=' . urlencode($row->modul) . '&type_template=' . urlencode($row->type_template)) }}"
                                        class="btn btn-info btn-sm">
                                        Kasih Soal
                                    </a>

                                    <a href="{{ route('kunci-jawaban.show', ['modul' => $row->modul, 'type_template' => $row->type_template]) }}"
                                        class="btn btn-success btn-sm">
                                        Kunci Jawaban
                                    </a>
                                @endif

                                {{-- BUTTON EDIT dan HAPUS TETAP --}}
                                <button type="button" onclick="toggleEdit({{ $row->id }})"
                                    class="btn btn-warning btn-sm">Edit</button>

                                <form action="{{ route('tarik-modul.destroy', $row->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin hapus?')"
                                        class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        {{-- FORM EDIT TANPA MODAL --}}
                        <tr>
                            <td colspan="5">
                                <div id="formEdit{{ $row->id }}" class="edit-box" style="display:none;">
                                    <h5>Edit Data</h5>

                                    <form action="{{ route('tarik-modul.update', $row->id) }}" method="POST">
                                        @csrf

                                        <div class="mb-3">
                                            <label>Modul</label>
                                            <textarea class="form-control" name="modul">{{ $row->modul }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label>Type Template</label>
                                            <textarea class="form-control" name="type_template">{{ $row->type_template }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label>Waktu</label>
                                            <textarea class="form-control" name="waktu">{{ $row->waktu }}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                                        <button type="button" onclick="toggleEdit({{ $row->id }})"
                                            class="btn btn-secondary btn-sm">Tutup</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- SCRIPT UNTUK TOGGLE FORM EDIT --}}
    <script>
        function toggleEdit(id) {
            // sembunyikan semua form edit dulu
            document.querySelectorAll('.edit-box').forEach(el => el.style.display = 'none');

            // toggle hanya yang diklik
            const box = document.getElementById('formEdit' + id);
            box.style.display = (box.style.display === 'none' || box.style.display === '') ? 'block' : 'none';
        }
    </script>


    <!-- MODAL TAMBAH DATA (TETAP ADA) -->
    <div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('tarik-modul.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label>Modul</label>
                            <textarea name="modul" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Type Template</label>
                            <select name="type_template" class="form-select" required>
                                <option value="">-- Pilih Type Template --</option>
                                <option value="data-nama">Data Nama</option>
                                <option value="panduan">Panduan</option>
                                <option value="angka-hilang">Angka-Hilang</option>
                                <option value="multiple-chois">Multiple-Chois</option>
                                <option value="tanpa-kembali">Tanpa-Kembali</option>
                                <option value="istirahat">Istirahat</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Waktu</label>
                            <textarea name="waktu" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleEdit(id) {
            let box = document.getElementById('formEdit' + id);

            if (box.style.display === 'none' || box.style.display === '') {
                box.style.display = 'block';
            } else {
                box.style.display = 'none';
            }
        }
    </script>


@endsection
