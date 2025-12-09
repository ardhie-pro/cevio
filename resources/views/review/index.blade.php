@extends('layouts.main')

@section('title', 'Daftar Kode Ujian')

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

        .table-responsive {
            overflow-x: auto;
        }

        .td-text {
            max-width: 350px;
            white-space: normal;
            word-break: break-word;
        }

        .td-text img {
            max-width: 100%;
            height: auto;
        }

        .td-img img {
            max-width: 120px;
            height: auto;
            display: block;
            margin: 5px auto;
        }

        .table td,
        .table th {
            vertical-align: top !important;
            white-space: normal !important;
            word-wrap: break-word;
            max-width: 300px;
        }

        /* Scroll responsif */
        .table-responsive {
            overflow-x: auto;
        }

        /* Agar kolom Opsi tidak terlalu lebar */
        .opsi-col {
            width: 120px;
        }
    </style>


    <div class="page-content">
        <div class="wrapper">

            <!-- start page title -->

            <!-- end page title -->

            <!-- Start Page-content-Wrapper -->

            <div class="row">
                <div class="col-12">

                    <div class="card-body">

                        <div class="table-responsive" style="max-height: 75vh; overflow-y: auto;">
                            <table class="table table-bordered align-middle mb-0">
                                <thead class="table-light sticky-top" style="top: 0; z-index: 10;">
                                    <tr>
                                        <th>ID</th>
                                        <th>Kode</th>
                                        <th>Modul</th>
                                        <th>Tanggal</th>
                                        <th>status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $row)
                                        <tr class="{{ $row->status == 0 ? 'table-success' : 'table-danger' }}">
                                            <td>{{ $index + 1 }}</td>
                                            <td><strong>{{ $row->kode }}</strong></td>
                                            <td>{{ $row->nama_modul ?? '-' }}</td>
                                            <td>{{ $row->waktu }} menit</td>
                                            <td>{{ ucfirst($row->status) }}</td>
                                            <td>
                                                <a href="{{ route('review.show', $row->kode) }}"
                                                    class="btn btn-sm btn-primary">
                                                    Review
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <!-- End Card -->
                </div>
            </div>

            <!-- End Page-content-Wrapper -->

        </div>
        <!-- End Container-Fluid -->
    </div>
@endsection
