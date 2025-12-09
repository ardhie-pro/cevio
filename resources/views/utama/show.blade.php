<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - CIBN</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background: url("{{ asset('assetts/images/weepo.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            /* biar full 1 layar */
            min-height: 100vh;
            position: relative;
            font-family: "Segoe UI", sans-serif;
        }

        /* Background Images */
        .bg-top {
            margin-top: -130px;
            position: absolute;
            top: 0;
            left: 0;
            width: 400px;
            height: auto;
            z-index: 0;
        }

        .bg-bottom {
            margin-right: -330px;
            position: absolute;
            bottom: 0;
            right: 0;
            width: 800px;
            height: auto;
            z-index: 0;
        }

        /* Login Card - GLASS EFFECT */
        .login-box {
            background: rgba(255, 255, 255, 0.094);
            /* kaca */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);

            border: 1px solid rgba(11, 75, 139, 0.196);
            /* biru transparan */
            border-radius: 15px;

            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.20);
            max-width: 700px;
            margin: 120px auto;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .login-left {
            width: 45%;
            text-align: center;
            padding: 20px;
            border-right: 5px solid rgba(0, 59, 118, 0.4);
            /* transparan agar cocok dengan efek kaca */
        }

        .login-left img {
            width: 170px;
            margin-bottom: 10px;
        }

        .login-left h5 {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
        }

        .login-right {
            width: 100%;
            padding: 30px 40px;
            background: rgba(255, 255, 255, 0);
            /* sedikit transparan */
            border-radius: 0 15px 15px 0;
            /* mengikuti bentuk card */
        }

        .login-right h4 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
            color: #333;
        }



        .form-control {
            background: rgba(255, 255, 255, 0);
            /* transparan */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);

            border: 1px solid rgba(11, 75, 139, 0.242);
            border-radius: 8px;

            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);

            color: #fff;
            /* biar tulisan tetap terlihat */
        }

        .btn-login {
            width: 100%;
            background-color: #007bff;
            color: white;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        .forgot {
            display: block;
            text-align: right;
            font-size: 12px;
            color: #007bff;
            text-decoration: none;
            margin-top: 5px;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-box {
                flex-direction: column;
                width: 90%;
            }

            .login-left {
                width: 100%;
                border-right: none;
                border-bottom: 2px solid rgba(11, 75, 139, 0.4);
            }

            .login-right {
                width: 100%;
                border-radius: 0 0 15px 15px;
            }

            .bg-top {
                margin-top: -145px;
                left: 0;
                width: 200px;
            }

            .bg-bottom {
                margin-right: -165px;
                margin-bottom: -200px;
                width: 400px;
            }
        }

        .fab-container {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 9999;
        }

        /* FAB Button tetap di posisi */
        .fab-button {
            width: 55px;
            height: 55px;
            background: #0d6efd;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 26px;
            cursor: pointer;
            position: absolute;
            bottom: 0;
            right: 0;
            transition: 0.3s;
        }

        .fab-button:hover {
            transform: scale(1.1);
        }

        /* FAB Menu harus di posisi absolute di atas tombol */
        .fab-menu {
            position: absolute;
            bottom: 70px;
            /* muncul di atas tombol */
            right: 0;
            display: none;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.25);
        }

        /* Floating Action Button */
        .fab-container {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 9999;
        }

        .fab-button {
            width: 55px;
            height: 55px;
            background: #0d6efd;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 26px;
            cursor: pointer;
            transition: 0.3s;
        }

        .fab-button:hover {
            transform: scale(1.1);
        }

        .fab-menu {
            display: none;
            margin-bottom: 10px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.25);
        }

        .fab-menu a,
        .fab-menu button {
            display: block;
            width: 150px;
            padding: 8px 12px;
            margin-bottom: 6px;
            text-decoration: none;
            background: #0d6efd;
            color: white;
            font-size: 14px;
            border-radius: 6px;
            border: none;
            text-align: center;
            cursor: pointer;
        }

        .fab-menu a:hover,
        .fab-menu button:hover {
            background: #084298;
        }

        .form-control::placeholder {
            color: #f8f9fa !important;
            opacity: 1;
        }

        body {
            background-color: #fff;
            min-height: 100vh;
            font-family: "Segoe UI", sans-serif;
            position: relative;
        }

        .bg-bottom {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 800px;
            height: auto;
            z-index: -1;
            margin-right: -330px;
        }

        .history-card {
            border: 2px solid #0b4b8b;
            border-radius: 10px;
            padding: 20px;
            background: #fff;
            transition: 0.3s;
        }

        .history-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .header-bar {
            padding: 15px 30px;
            border-bottom: 2px solid #0b4b8b;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background-color: #0b4b8b;
            border-radius: 50%;
        }

        .history-card {
            background: rgba(255, 255, 255, 0.09);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(11, 75, 139, 0.25);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            color: #fff;
            min-height: 150px;

            display: flex;
            flex-direction: column;
            justify-content: center;

            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        /* batasi 3 baris */
        .history-card p {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        /* tombol lihat laporan kecil dan rapi */
        .btn-history {
            display: block;
            margin: 10px auto 0 auto;
            width: fit-content;
        }

        .history-card a,
        .history-card a:hover,
        .history-card a:focus {
            text-decoration: none !important;
        }

        /* atau hilangkan underline untuk semua link dalam card container */
        .history-card {
            text-decoration: none !important;
        }

        a {
            text-decoration: none !important;
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
        <div class="card" style="display:none;">

            <!-- Judul Halaman -->
            <div class="row" style="display:none;">
                <div class="col-12" style="display:none;">

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
            <div class="row mb-3 " style="display:none;">
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
            <div class="card mb-4 laporan-modul" data-modul="{{ $modul }}" style="display:none;">
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


            </div>
        @empty
            <div class="alert alert-warning mt-4">
                Tidak ada jawaban yang dapat ditampilkan.
            </div>
        @endforelse

    </div>

    <div class="container">
        <div class="row mt-5">
            <div class="history-card col-12">
                <div class="card-header text-white">
                    <h5 class="mb-0">📊 Grafik Rekap Semua Modul</h5>
                </div>
                <div class="card-body">
                    <canvas id="chart_global" height="140"></canvas>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="history-card col-12">
                <div class="card-header mt-2 text-white">
                    <h5 class="mb-5">Total Keseluruhan Semua Modul</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4 col-md-2 mb-2">
                            <strong>Total Soal</strong>
                            <div class="fs-5" id="total_all_soal">0</div>
                        </div>
                        <div class="col-4 col-md-2 mb-2">
                            <strong>Dijawab</strong>
                            <div class="fs-5" id="total_all_dijawab">0</div>
                        </div>
                        <div class="col-4 col-md-2 mb-2 text-success">
                            <strong>Benar</strong>
                            <div class="fs-5" id="total_all_benar">0</div>
                        </div>
                        <div class="col-4 col-md-2 mb-2 text-danger">
                            <strong>Salah</strong>
                            <div class="fs-5" id="total_all_salah">0</div>
                        </div>
                        <div class="col-4 col-md-2 mb-2 text-primary">
                            <strong>Total Poin</strong>
                            <div class="fs-5" id="total_all_poin">0</div>
                        </div>
                    </div>
                </div>
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
                                position: 'bottom',
                                labels: {
                                    color: '#fff' // warna teks legend putih
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: '#fff' // warna label X
                                },
                                grid: {
                                    color: 'rgba(255,255,255,0.2)' // grid putih tipis
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#fff' // warna label Y
                                },
                                grid: {
                                    color: 'rgba(255,255,255,0.2)' // grid putih tipis
                                }
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
                        card.style.display = selected === '' || modul === selected ? '' :
                            'none';
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
    <script>
        /* ============================================================
                                                                                                                                                                   🧮 TOTALAN GLOBAL (BENAR, SALAH, DIJAWAB, POIN)
                                                                                                                                                                ============================================================ */
        let totalSoalAll = 0;
        let totalDijawabAll = 0;
        let totalBenarAll = 0;
        let totalSalahAll = 0;
        let totalPoinAll = 0;

        // LOOP semua card modul
        document.querySelectorAll('.laporan-modul').forEach(card => {
            // ambil rekap
            const rekap = card.querySelector('.rekap');
            if (rekap) {
                totalSoalAll += parseInt(rekap.querySelector('.total-soal')?.textContent || 0);
                totalDijawabAll += parseInt(rekap.querySelector('.dijawab')?.textContent || 0);
                totalBenarAll += parseInt(rekap.querySelector('.benar')?.textContent || 0);
                totalSalahAll += parseInt(rekap.querySelector('.salah')?.textContent || 0);
            }

            // ambil poin dari tabel
            card.querySelectorAll('tbody tr').forEach(tr => {
                const poin = parseInt(tr.querySelector('td:last-child')?.textContent || 0);
                if (!isNaN(poin)) totalPoinAll += poin;
            });
        });

        // MASUKKAN NILAI KE HTML
        document.getElementById('total_all_soal').textContent = totalSoalAll;
        document.getElementById('total_all_dijawab').textContent = totalDijawabAll;
        document.getElementById('total_all_benar').textContent = totalBenarAll;
        document.getElementById('total_all_salah').textContent = totalSalahAll;
        document.getElementById('total_all_poin').textContent = totalPoinAll;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    -->
    </body>

</html>
