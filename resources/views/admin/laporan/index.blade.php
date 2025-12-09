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


        <!-- start page title -->
        <div class="wrapper">
            <div class="row">
                <div class="col-12">

                    <div class="page-title">
                        <h4 class="mb-0 font-size-18">Selamat Datang</h4>
                    </div>
                </div>
            </div>
        </div>


        <!-- end page title -->

        <div class="wrapper">
            <div class="row">
                <div class="col-12">


                    <div class="card-body py-4">
                        <h4>📘 Daftar Kode Ujian</h4>

                        <!-- 🔍 Search Bar -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <input type="text" id="searchKode" class="form-control"
                                    placeholder="Cari berdasarkan kode ujian...">
                            </div>
                        </div>

                        <table class="table table-bordered table-hover" id="kodeTable">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Peserta</th>
                                    <th>Nama Modul</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $row)
                                    @php
                                        $rowColor = $row->status == 0 ? 'table-success' : 'table-danger';
                                    @endphp
                                    <tr class="{{ $rowColor }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td class="kode-cell"><strong>{{ $row->kode }}</strong></td>
                                        <td>{{ $row->nama_peserta ?? '-' }}</td>
                                        <td>{{ $row->nama_modul ?? '-' }}</td>
                                        <td>{{ $row->waktu }} menit</td>
                                        <td>{{ ucfirst($row->status) }}</td>
                                        <td>
                                            <a href="{{ route('laporan.show', $row->kode) }}" class="btn btn-info btn-sm">
                                                <i class="mdi mdi-eye"></i> Lihat Laporan
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end card-body -->

                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- 🔍 Script Search -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("searchKode");
            const tableRows = document.querySelectorAll("#kodeTable tbody tr");

            searchInput.addEventListener("keyup", function() {
                const keyword = this.value.toLowerCase();

                tableRows.forEach(row => {
                    const kodeText = row.querySelector(".kode-cell").textContent.toLowerCase();
                    row.style.display = kodeText.includes(keyword) ? "" : "none";
                });
            });
        });
    </script>
@endsection
