@extends('layouts.main')

@section('title', 'Laporan Jawaban User')

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
        <div class="card">

            <!-- Judul Halaman -->
            <div class="row">
                <div class="col-12">

                    <div class="page-title">
                        <h4 class="mb-0 font-size-18">
                            📊 Laporan Jawaban User — <span class="text-primary">Kode: {{ $kode }}</span>
                        </h4>
                    </div>
                    <div class="d-flex gap-2 mt-5">
                        <button id="btnExportExcel" class="btn btn-success">
                            <i class="mdi mdi-file-excel"></i> Export ke Excel
                        </button>
                        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🔍 Filter Modul -->
        @if (count($data) > 1)
            <div class="row mb-3">
                <div class="col-md-4">
                    <select id="filterModul" class="form-select">
                        <option value="">Tampilkan Semua Modul</option>
                        @foreach ($data as $modul => $detail)
                            <option value="{{ $modul }}">{{ $modul }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        <!-- 📘 Laporan Tiap Modul -->
        @forelse ($data as $modul => $detail)
            <div class="card mb-4 laporan-modul" data-modul="{{ $modul }}">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Modul: {{ $modul }}</h5>
                    <span class="badge bg-light text-dark">
                        Total Poin: <strong>{{ $detail['total_poin'] }}</strong>
                    </span>
                </div>

                @if (isset($detail['rekap']))
                    <div class="rekap alert alert-info mb-4">
                        <h6 class="mb-3">📋 Rekapitulasi Hasil:</h6>
                        <div class="row text-center">
                            <div class="col-md-3 col-6 mb-2">
                                <strong>Total Soal:</strong>
                                <div class="fs-5 total-soal">{{ $detail['rekap']['total_soal'] }}</div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <strong>Dijawab:</strong>
                                <div class="fs-5 dijawab">{{ $detail['rekap']['dijawab'] }}</div>
                            </div>
                            <div class="col-md-3 col-6 mb-2 text-success">
                                <strong>Benar:</strong>
                                <div class="fs-5 benar">{{ $detail['rekap']['benar'] }}</div>
                            </div>
                            <div class="col-md-3 col-6 mb-2 text-danger">
                                <strong>Salah:</strong>
                                <div class="fs-5 salah">{{ $detail['rekap']['salah'] }}</div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card-body p-0">
                    <table class="table table-bordered mb-0 text-center align-middle laporan-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">No</th>
                                <th>Jawaban User</th>
                                <th>Kunci Jawaban</th>
                                <th style="width: 100px;">Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail['soal'] as $row)
                                <tr>
                                    <td>{{ $row['no'] }}</td>
                                    <td
                                        class="@if ($row['status'] == 'salah') bg-danger text-white
                                            @elseif($row['status'] == 'benar') bg-success text-white @endif">
                                        {{ $row['jawaban_user'] ?? '-' }}
                                    </td>
                                    <td>{{ $row['jawaban_benar'] ?? '-' }}</td>
                                    <td>{{ $row['poin'] ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="alert alert-warning mt-4">
                Tidak ada jawaban yang dapat ditampilkan.
            </div>
        @endforelse
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">📊 Grafik Rekap Semua Modul</h5>
            </div>
            <div class="card-body">
                <canvas id="chart_global" height="140"></canvas>
            </div>
        </div>

    </div>
    </div>

    <!-- 🧠 Script Filter + Export -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            /* ============================================================
               🔥  BAGIAN GRAFIK GLOBAL (AUTO AMBIL DATA DARI SETIAP .rekap)
            ============================================================ */
            const rekapList = document.querySelectorAll('.rekap');
            const labels = [];
            const dataTotal = [];
            const dataDijawab = [];
            const dataBenar = [];
            const dataSalah = [];
            const modul = "{{ $modul }}";



            let index = 1;

            rekapList.forEach((r, i) => {
                const card = r.closest('.laporan-modul');
                const namaModul = card.dataset.modul || `Modul-${i+1}`;
                labels.push(namaModul);

                dataTotal.push(parseInt(r.querySelector('.total-soal')?.textContent || 0));
                dataDijawab.push(parseInt(r.querySelector('.dijawab')?.textContent || 0));
                dataBenar.push(parseInt(r.querySelector('.benar')?.textContent || 0));
                dataSalah.push(parseInt(r.querySelector('.salah')?.textContent || 0));
            });

            if (rekapList.length > 0) {
                const ctx = document.getElementById('chart_global').getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Total Soal',
                                data: dataTotal,
                                backgroundColor: 'rgba(0,0,0,0.5)'
                            },
                            {
                                label: 'Dijawab',
                                data: dataDijawab,
                                backgroundColor: 'rgba(0,123,255,0.6)'
                            },
                            {
                                label: 'Benar',
                                data: dataBenar,
                                backgroundColor: 'rgba(40,167,69,0.6)'
                            },
                            {
                                label: 'Salah',
                                data: dataSalah,
                                backgroundColor: 'rgba(220,53,69,0.6)'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            /* ============================================================
               🔍  FILTER MODUL
            ============================================================ */
            const filter = document.getElementById('filterModul');
            const btnExport = document.getElementById('btnExportExcel');

            if (filter) {
                filter.addEventListener('change', function() {
                    const selected = this.value.toLowerCase();
                    document.querySelectorAll('.laporan-modul').forEach(card => {
                        const modul = card.dataset.modul.toLowerCase();
                        card.style.display = selected === '' || modul === selected ? '' : 'none';
                    });
                });
            }

            /* ============================================================
               📤 EXPORT EXCEL (REKAP + TABEL)
            ============================================================ */
            btnExport.addEventListener('click', function() {
                const allCards = document.querySelectorAll('.laporan-modul');
                if (allCards.length === 0) {
                    alert('⚠️ Tidak ada data untuk diekspor!');
                    return;
                }

                const wb = XLSX.utils.book_new();

                allCards.forEach(card => {
                    const modul = card.dataset.modul || 'Tanpa Modul';
                    const rekapDiv = card.querySelector('.rekap');
                    const table = card.querySelector('table');

                    const rekapData = [];
                    if (rekapDiv) {
                        const total = rekapDiv.querySelector('.total-soal')?.textContent || '-';
                        const dijawab = rekapDiv.querySelector('.dijawab')?.textContent || '-';
                        const benar = rekapDiv.querySelector('.benar')?.textContent || '-';
                        const salah = rekapDiv.querySelector('.salah')?.textContent || '-';
                        rekapData.push(["📋 Rekapitulasi Hasil"]);
                        rekapData.push(["Total Soal", total]);
                        rekapData.push(["Dijawab", dijawab]);
                        rekapData.push(["Benar", benar]);
                        rekapData.push(["Salah", salah]);
                        rekapData.push([]);
                    }

                    const wsRekap = XLSX.utils.aoa_to_sheet(rekapData);
                    const wsTable = XLSX.utils.table_to_sheet(table);
                    XLSX.utils.sheet_add_json(wsRekap, XLSX.utils.sheet_to_json(wsTable, {
                        header: 1
                    }), {
                        origin: -1
                    });

                    XLSX.utils.book_append_sheet(wb, wsRekap, modul.substring(0, 31));
                });

                const tanggal = new Date().toISOString().slice(0, 10);
                const filename = `Laporan_Semua_Modul_{{ $kode }}_${tanggal}.xlsx`;

                XLSX.writeFile(wb, filename);
                alert('✅ Semua tabel + rekap berhasil diekspor ke Excel!');
            });

        });
    </script>

@endsection
