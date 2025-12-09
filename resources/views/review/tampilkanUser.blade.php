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
        <div class="wrapper">


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
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Grup</th>

                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $row)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><strong>{{ $row->name }}</strong></td>
                                            <td><strong>{{ $row->status }}</strong></td>
                                            <td><strong>{{ $row->grup }}</strong></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modalHistory{{ $row->id }}">
                                                    Cek Data
                                                </button>
                                            </td>
                                        </tr>

                                        {{-- 🔥 MODAL --}}
                                        <div class="modal fade" id="modalHistory{{ $row->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Riwayat Data — {{ $row->name }}</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        @php
                                                            $items = explode(',', $row->history ?? '');
                                                        @endphp

                                                        @if (count($items) > 0)
                                                            @foreach ($items as $i => $item)
                                                                @php
                                                                    $kode = trim($item);
                                                                    $info = \App\Models\Kode::where(
                                                                        'kode',
                                                                        $kode,
                                                                    )->first();
                                                                @endphp

                                                                <a href="{{ url('review/' . trim($kode)) }}"
                                                                    class="text-decoration-none d-block mb-3">
                                                                    <div
                                                                        class="p-3 btn-answered shadow-sm rounded-4 card-history">

                                                                        {{-- NOMOR & KODE --}}
                                                                        <h6 class="mb-1">
                                                                            <strong>{{ $i + 1 }}.
                                                                                {{ $kode }}</strong>
                                                                        </h6>

                                                                        @if ($info)
                                                                            {{-- MODUL --}}
                                                                            @php
                                                                                $moduls = \App\Models\TarikModul::where(
                                                                                    'id',
                                                                                    $info->modul_id,
                                                                                )->pluck('modul');
                                                                            @endphp

                                                                            <div class="small text-muted mb-1">
                                                                                Modul:
                                                                                @forelse ($moduls as $m)
                                                                                    <span
                                                                                        class="fw-bold">{{ $m }}</span><br>
                                                                                @empty
                                                                                    -
                                                                                @endforelse
                                                                            </div>

                                                                            {{-- WAKTU --}}
                                                                            <div class="small text-secondary">
                                                                                {{ $info->created_at?->format('d M Y H:i') }}
                                                                            </div>
                                                                        @else
                                                                            <div class="text-danger small">
                                                                                Kode tidak ditemukan
                                                                            </div>
                                                                        @endif

                                                                    </div>
                                                                </a>
                                                            @endforeach
                                                        @else
                                                            <p class="text-muted">Tidak ada history.</p>
                                                        @endif
                                                    </div>


                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
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
