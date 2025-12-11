@extends('layouts.main-page')

@section('title', 'Dashboard')

@section('content4')
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed: 72px;
            --brand-color: #0d6efd;
            --muted: #6c757d;
            --card-radius: .8rem;
        }

        body {
            min-height: 100vh;
            background: #f6f8fb;
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            background: #ffffff;
            border-right: 1px solid rgba(18, 38, 63, .06);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            padding: 1rem 0.6rem;
            transition: width .25s ease;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
            min-width: var(--sidebar-collapsed);
        }

        .sidebar .brand {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: 0 12px;
            margin-bottom: 1rem;
        }

        .brand .brand-text {
            font-weight: 700;
            font-size: 1.05rem
        }

        .nav-link {
            color: #324055;
            border-radius: .6rem;
            padding: .55rem .75rem;
            margin: .15rem 0;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(13, 110, 253, .06);
            color: var(--brand-color);
        }

        /* CONTENT */
        .main {
            margin-left: var(--sidebar-width);
            transition: margin-left .25s ease;
            padding: 1.4rem;
        }

        .sidebar.collapsed+.main {
            margin-left: var(--sidebar-collapsed);
        }

        .topbar {
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .card-lg {
            border-radius: var(--card-radius);
            box-shadow: 0 6px 18px rgba(28, 40, 76, 0.06);
        }

        /* responsive tweaks */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                left: -9999px;
            }

            .sidebar.show {
                left: 0;
                z-index: 1050;
            }

            .main {
                margin-left: 0;
            }
        }

        /* small helpers */
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-block;
            background: linear-gradient(135deg, #ddd, #eee);
        }

        .muted {
            color: var(--muted);
        }

        /* table responsive card */
        .table-responsive-card {
            overflow: auto;
        }
    </style>

    <div class="container mt-5">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1">{{ $event->nama_event }}</h3>
                    <p class="text-muted mb-2">
                        <b>Lokasi:</b> {{ $event->lokasi }} |
                        <b>Client:</b> {{ $event->client }}
                    </p>
                    <span
                        class="badge
                @if ($event->status == 'Pending') bg-warning
                @elseif($event->status == 'Berjalan') bg-primary
                @else bg-success @endif
            ">
                        {{ $event->status }}
                    </span>
                </div>

                <div class="text-end">
                    <select id="eventStatus" class="form-select fw-bold" style="width: 180px;">
                        <option {{ $event->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option {{ $event->status == 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                        <option {{ $event->status == 'Close' ? 'selected' : '' }}>Close</option>
                    </select>

                    <button class="btn btn-dark mt-3" data-bs-toggle="collapse" data-bs-target="#detailEvent">
                        Lihat Semua Detail
                    </button>
                </div>
            </div>
        </div>
        <div id="detailEvent" class="collapse">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <h5 class="mb-3">Detail Event</h5>
                    <div class="row mb-4">

                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Project Manager</label>
                            <p>{{ $event->project_manager }}</p>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Nilai Project</label>
                            <p>Rp {{ number_format($event->nilai_project, 0, ',', '.') }}</p>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Status</label>
                            <p>{{ $event->status }}</p>
                        </div>

                        <hr class="mt-2">

                        <h5 class="mt-3">Durasi & Waktu</h5>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Mulai Pelaksanaan</label>
                            <p>{{ $event->mulai_pelaksanaan }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Selesai Pelaksanaan</label>
                            <p>{{ $event->selesai_pelaksanaan }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Mulai Persiapan</label>
                            <p>{{ $event->mulai_persiapan }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Selesai Persiapan</label>
                            <p>{{ $event->selesai_persiapan }}</p>
                        </div>

                        <hr>

                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Durasi Pelaksanaan</label>
                            @php
                                $total2 = $event->durasi_pelaksanaan;
                                $hari2 = floor($total2 / 24);
                                $jam2 = $total2 % 24;
                            @endphp
                            <p class="fw-bold text-primary">
                                {{ $hari2 > 0 ? $hari2 . ' Hari ' : '' }}{{ $jam2 }} Jam
                            </p>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Durasi Persiapan</label>
                            @php
                                $total1 = $event->durasi_persiapan;
                                $hari1 = floor($total1 / 24);
                                $jam1 = $total1 % 24;
                            @endphp
                            <p class="fw-bold text-primary">
                                {{ $hari1 > 0 ? $hari1 . ' Hari ' : '' }}{{ $jam1 }} Jam
                            </p>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Total Durasi</label>

                            @php
                                $total = $event->total_durasi;
                                $hari = floor($total / 24);
                                $jam = $total % 24;
                            @endphp

                            <p class="fw-bold text-primary">
                                {{ $hari > 0 ? $hari . ' Hari ' : '' }}{{ $jam }} Jam
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>



        <div class="row">

            <!-- CARD KEUANGAN -->
            <div class="col-md-6">
                <a href="{{ route('event.keuangan', $event->id) }}" class="text-decoration-none">
                    <div class="card shadow-sm p-4 text-center">
                        <h4>Data Keuangan</h4>
                        <p class="text-muted">Pemasukan & Pengeluaran</p>
                    </div>
                </a>
            </div>

            <!-- CARD KRU -->
            <div class="col-md-6">
                <a href="{{ route('event.kru', $event->id) }}" class="text-decoration-none">
                    <div class="card shadow-sm p-4 text-center">
                        <h4>Data Kru Event</h4>
                        <p class="text-muted">Tambah & Edit Kru</p>
                    </div>
                </a>
            </div>

            <div id="pdfCard" class="col-md-12 mt-4 d-none">
                <a href="{{ route('event.pdfSemua', $event->id) }}" class="text-decoration-none">
                    <div class="card shadow-sm p-4 text-center bg-primary text-white">
                        <h4>📄 Download Laporan Lengkap Event</h4>
                        <p class="text-light">Berisi Data Event, Keuangan, & Kru</p>
                    </div>
                </a>
            </div>

        </div>

    </div>


    <!-- Bootstrap JS (Popper included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const status = document.getElementById('eventStatus');
            const pdfCard = document.getElementById('pdfCard');

            function checkStatus() {
                if (status.value === 'Close') {
                    pdfCard.classList.remove('d-none');
                } else {
                    pdfCard.classList.add('d-none');
                }
            }

            status.addEventListener('change', checkStatus);

            // jalankan saat halaman dimuat
            checkStatus();
        });
    </script>

    <script>
        // Sidebar toggle for small screens
        const btn = document.getElementById('btnToggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const main = document.getElementById('main');

        btn && btn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });

        // Collapse sidebar on large screens (optional)
        // You can add a button to toggle collapsed class if needed
        // Example: document.getElementById('collapseBtn').addEventListener(...)

        // Auto-close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 992) {
                if (!sidebar.contains(e.target) && !btn.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    </script>

    <script>
        document.getElementById('eventStatus').addEventListener('change', function() {
            fetch("{{ route('event.update.status', $event->id) }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        status: this.value
                    })
                })
                .then(res => res.json())
                .then(res => {
                    console.log("STATUS UPDATED");
                });
        });
    </script>


@endsection
