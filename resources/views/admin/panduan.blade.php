@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <style>
        body {
            background: #f4f6fb;
            padding: 0;
            font-family: "Inter", Arial, sans-serif;
        }

        h1 {
            text-align: center;
            font-size: 36px;
            font-weight: 800;
            color: #222;
            margin: 0;
        }

        h2 {
            color: #4b4b4b;
            text-align: center;
            margin-top: 6px;
            font-weight: 400;
            letter-spacing: 0.5px;
        }

        /* WRAPPER */
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

        /* GRID */
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr !important;
            }
        }

        /* CARD */
        .card {
            background: #ffffff;
            border-radius: 14px;
            padding: 22px;
            border: 1px solid #dde3ee;
            box-shadow:
                0 3px 6px rgba(0, 0, 0, 0.05),
                0 1px 2px rgba(0, 0, 0, 0.04);
            transition: 0.25s ease;
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.14),
                0 4px 10px rgba(0, 0, 0, 0.08);
            border-color: #b8c6df;
        }

        /* ROW */
        .row {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        /* FIELD BOX */
        .box {
            flex: 1;
            background: #e7e9ef;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #4d4d4d;
            letter-spacing: 0.3px;
            min-width: 0;
            word-break: break-word;
        }

        /* BUTTON */
        .btn-custom {
            width: 95px;
            background: #F4C542 !important;
            color: #0E2542 !important;
            padding: 10px 0;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            cursor: pointer;
            transition: 0.25s;
            border: none !important;
            flex-shrink: 0;
        }


        .btn-custom:hover {
            background: #e1b63b !important;
        }

        .btn-danger-sm {
            background: #c0392b !important;
            color: white !important;
        }

        .btn-danger-sm:hover {
            background: #962d22 !important;
        }

        .dataTables_length {
            display: none !important;
        }

        .dataTables_filter {
            display: none !important;
        }

        .dataTables_info {
            display: none !important;
        }

        .card-animate {
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 1.6s ease-out forwards;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-answered {
            background-color: #244e9b;
            /* biru Bootstrap */
            color: white;
        }
    </style>



    <div class="page-content">
        <div id="formTambahSoal" class="wrapper" style="display:none;">
            <div class="row">
                <div class="col-12">

                    <div class="card-body">
                        <h5 class="mb-3">Penulisan Panduan</h5>

                        <form action="{{ route('soal-multiple.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="modul" value="{{ $modul }}">
                            <input type="hidden" name="no" class="form-control" value="1" required>
                            <div class="mb-3">

                                <textarea id="elm_soal" name="soal" rows="3"></textarea>
                            </div>
                            <hr>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" id="batalBtn" class="btn btn-secondary">Batal</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


        <div id="formEditSoal" style="display: none;">
            <div class="wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card-body">
                            <h5 class="mb-3">Edit Penulisan Panduan</h5>

                            <form id="editSoalForm" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" id="edit_id">
                                <input type="hidden" name="modul" id="edit_modul">
                                <input type="hidden" name="no" id="edit_no" class="form-control" required>

                                <div class="mb-3">

                                    <textarea id="edit_soal" name="soal" rows="3"></textarea>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <button type="button" id="batalEditBtn" class="btn btn-secondary">Batal</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="wrapper mt-5">


            <div class="row">
                <div class="col-12">

                    <div class="card-body">
                        <h4 class="card-title">
                            Daftar Modul
                        </h4>
                        <p class="card-title-desc">
                            Silahkan Bisa Menambahkan Dan Juga Meng Edit Data Modul Disini
                        </p>
                        <div class="mb-3">
                            <button type="button" id="tambahSoalBtn" class="btn btn-success">
                                + Tambah Soal
                            </button>
                        </div>

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="
                                                    border-collapse: collapse;
                                                    border-spacing: 0;
                                                    width: 100%;
                                                ">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Soal</th>
                                    <th>Aksi</th>

                                </tr>
                            </thead>

                            <tbody>
                                @forelse($data2 as $item)
                                    <tr>
                                        <td>{{ $item->no }}</td>

                                        <td>
                                            {{ $item->soal }}
                                        </td>


                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm"
                                                onclick="showEditForm('{{ $item->id }}', '{{ $item->modul }}', `{{ $item->soal }}`,`{{ $item->pembahasan }}`, `{{ $item->no }}`, `{{ $item->j1 }}`, `{{ $item->j2 }}`, `{{ $item->j3 }}`, `{{ $item->j4 }}`, `{{ $item->j5 }}`)">
                                                Edit
                                            </button>

                                            <form action="{{ route('soal.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button onclick="return confirm('Yakin hapus?')"
                                                    class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Belum ada soal untuk modul ini.
                                        </td>
                                    </tr>
                                    <!-- Modal Edit -->
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- end col -->
            </div>
        </div>
        <!-- End Row -->


    </div>
    <!-- End Page-content -->
    <div class="wrapper">

        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h5 class="mb-0">📷 Manajemen Galeri</h5>
            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" class="d-flex">
                @csrf
                <input type="file" name="img" class="form-control form-control-sm me-2" required>
                <button class="btn btn-light btn-sm">Tambah</button>
            </form>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row">
                @foreach ($galeri as $item)
                    <div class="col-md-3 mb-4">
                        <div class="card shadow-sm">
                            <img src="{{ asset('storage/' . $item->img) }}" class="card-img-top" alt="img">
                            <div class="card-body text-center">
                                <small class="d-block text-muted mb-2">
                                    <input type="text" class="form-control form-control-sm text-center" readonly
                                        value="{{ asset('storage/' . $item->img) }}"
                                        onclick="navigator.clipboard.writeText(this.value); alert('Link disalin!');">
                                </small>
                                <form action="{{ route('admin.galeri.update', $item->id) }}" method="POST"
                                    enctype="multipart/form-data" class="d-inline">
                                    @csrf
                                    <input type="file" name="img" class="form-control form-control-sm mb-2">
                                    <button class="btn btn-warning btn-sm">Ubah</button>
                                </form>
                                <form action="{{ route('admin.galeri.delete', $item->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin ingin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    </div>

    </div>
    <!-- Container-Fluid -->
    </div>

@endsection
