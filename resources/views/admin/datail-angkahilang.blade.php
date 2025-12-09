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

        <div class="wrapper card-animate mt-5">
            <div class="title mb-4">Detail Grup: {{ $nama }}</div>
            <button class="btn btn-answered mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahKolom">
                + Tambah Kolom
            </button>
            <div class="modal fade" id="modalTambahKolom" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('grup.tambahKolom') }}" method="POST" class="modal-content">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Kolom Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <input type="hidden" name="nama_grup" value="{{ $nama }}">

                            <div class="mb-3">
                                <label>Nama isi baru</label>
                                <input type="text" name="isi_baru" class="form-control"
                                    placeholder="contoh: papikostik 4" required>
                            </div>

                            <div class="mb-3">
                                <label>Waktu Modul (detik)</label>
                                <input type="number" name="waktu" class="form-control" value="60" required>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-success">Tambah</button>
                        </div>

                    </form>
                </div>
            </div>



            <div class="row g-3">

                @foreach ($modul as $m)
                    <div class="col-md-6">
                        <div class="btn btn-answered w-100 d-flex justify-content-between align-items-center p-3">

                            <!-- NAMA MODUL -->
                            <a href="{{ url('/soal?modul=' . urlencode($m->modul) . '&type_template=' . urlencode($m->type_template)) }}"
                                class="text-reset text-decoration-none">
                                <h4 class="m-0">{{ $m->modul }}</h4>
                            </a>

                            <!-- ICON EDIT & DELETE -->
                            <span class="d-flex gap-2">
                                <a href="#" class="text-reset" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $m->id }}">
                                    <i class="bx bx-edit fs-4"></i>
                                </a>

                                <a href="#" class="text-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $m->id }}">
                                    <i class="bx bx-trash fs-4"></i>
                                </a>
                                <a href="{{ route('kunci-jawaban.show', ['modul' => $m->modul, 'type_template' => $m->type_template]) }}"
                                    class="text-warning">
                                    <i class="bx bxs-lock fs-4"></i>
                                </a>


                            </span>
                        </div>
                    </div>

                    <!-- =======================
                                                         MODAL EDIT
                                                    ==========================-->
                    <div class="modal fade" id="editModal{{ $m->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('modul.update', $m->id) }}" method="POST">
                                @csrf @method('PUT')

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Edit Modul</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <label>Nama Modul</label>
                                        <input type="text" name="modul" class="form-control"
                                            value="{{ $m->modul }}">

                                        <label class="mt-3">Waktu (detik)</label>
                                        <input type="number" name="waktu" class="form-control"
                                            value="{{ $m->waktu }}">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- =======================
                                                         MODAL DELETE
                                                    ==========================-->
                    <div class="modal fade" id="deleteModal{{ $m->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('modul.delete', $m->id) }}" method="POST">
                                @csrf @method('DELETE')

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Hapus Modul</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        Apakah kamu yakin ingin menghapus modul:
                                        <b>{{ $m->modul }}</b> ?
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div>

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


@endsection
