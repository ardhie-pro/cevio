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
    </style>
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="wrapper">
                <div class="row">
                    <div class="col-12">

                        <div class="page-title">
                            <h4 class="mb-0 font-size-18">Generate Kode</h4>
                        </div>

                    </div>
                </div>
            </div>

            <!-- end page title -->

            <!-- Start Page-content-Wrapper -->
            <div class="wrapper">
                <div class="row">
                    <div class="col-12">

                        <div class="card-body">

                            <h4>Generate Kode Modul</h4>
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('generate-kode.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Jumlah Kode</label>
                                    <input type="number" name="jumlah" class="form-control" min="1" required>
                                </div>

                                <div class="form-group mt-3">
                                    <label>Pilih Modul</label>
                                    <select name="modul_id" class="form-control" required>
                                        <option value="">-- Pilih Modul --</option>
                                        @foreach ($modul as $m)
                                            <option value="{{ $m->id }}">{{ $m->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mt-3">
                                    <label>Tanggal Berlaku Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control" required>
                                </div>

                                <div class="form-group mt-3">
                                    <label>Tanggal Berlaku Sampai</label>
                                    <input type="date" name="tanggal_selesai" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary mt-4">Generate</button>
                            </form>

                        </div>
                        <!-- End Cardbody -->

                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
            <div class="wrapper">
                <div class="row">
                    <div class="col-12">

                        <div class="card-body">
                            <div class="container-fluid">
                                <h4 class="mb-4">📅 Daftar Kode Generator (Status = 0)</h4>

                                {{-- 🔍 Filter --}}
                                <form method="GET" action="{{ route('generate-kode.index') }}" class="mb-3">
                                    <div class="row align-items-end">
                                        <div class="col-md-3">
                                            <label for="tanggal_mulai" class="form-label">Filter Tanggal Mulai</label>
                                            <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                                class="form-control" value="{{ request('tanggal_mulai') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="modul_id" class="form-label">Filter Modul</label>
                                            <select name="modul_id" id="modul_id" class="form-select">
                                                <option value="">-- Semua Modul --</option>
                                                @foreach ($modul as $m)
                                                    <option value="{{ $m->id }}"
                                                        {{ request('modul_id') == $m->id ? 'selected' : '' }}>
                                                        {{ $m->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="{{ route('generate-kode.index') }}" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </div>
                                </form>

                                {{-- 📋 Tabel Data --}}
                                <div class="table-responsive">
                                    <table id="datatable-buttons"
                                        class="table table-striped table-bordered dt-responsive nowrap">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>NO</th>
                                                <th>Kode</th>
                                                <th>Nama Modul</th>
                                                <th>Waktu</th>
                                                <th>Status</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Selesai</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $index => $row)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td><strong class="text-primary">{{ $row->kode }}</strong></td>
                                                    <td>{{ $row->nama_modul }}</td>
                                                    <td>{{ $row->waktu }} menit</td>
                                                    <td>
                                                        <span class="badge bg-success">0 (Belum Digunakan)</span>
                                                    </td>
                                                    <td>{{ $row->tanggal_mulai ? \Carbon\Carbon::parse($row->tanggal_mulai)->format('d M Y') : '-' }}
                                                    </td>
                                                    <td>{{ $row->tanggal_selesai ? \Carbon\Carbon::parse($row->tanggal_selesai)->format('d M Y') : '-' }}
                                                    </td>
                                                    <td class="text-center">
                                                        <form action="{{ route('generate-kode.destroy', $row->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Yakin ingin menghapus kode ini?')"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-outline-danger btn-sm">
                                                                <i class="mdi mdi-trash-can-outline"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted">
                                                        Tidak ada kode dengan status 0
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endsection
