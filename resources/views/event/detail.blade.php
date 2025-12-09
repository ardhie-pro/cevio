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

    <div class="container">

        <!-- HEADER EVENT -->
        <div class="card shadow-sm mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1">{{ $event->nama_event }}</h3>
                    <small class="text-muted">
                        Lokasi: {{ $event->lokasi }} |
                        Client: {{ $event->client }}
                    </small>
                </div>
                @if (auth()->user()->status != 'manajer')
                    <div>
                        <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalPemasukan">
                            <i class="bi bi-plus-circle"></i> Tambah Pemasukan
                        </button>

                        <button class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#modalPengeluaran">
                            <i class="bi bi-dash-circle"></i> Tambah Pengeluaran
                        </button>

                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalKru">
                            <i class="bi bi-people"></i> Tambah Kru
                        </button>
                    </div>
                @endif

            </div>
        </div>

        <!-- TOTAL RINGKASAN -->
        @php
            $total_pemasukan = $event->pemasukan->sum('nominal');
            $total_pengeluaran = $event->pengeluaran->sum('nominal');
            $laba = $total_pemasukan - $total_pengeluaran;
        @endphp

        <div class="row mb-4">

            <!-- PEMASUKAN -->
            <div class="col-md-4">
                <div class="card border-success shadow-sm">
                    <div class="card-body">
                        <h5 class="text-success">Total Pemasukan</h5>
                        <h3>Rp {{ number_format($total_pemasukan) }}</h3>
                    </div>
                </div>
            </div>

            <!-- PENGELUARAN -->
            <div class="col-md-4">
                <div class="card border-danger shadow-sm">
                    <div class="card-body">
                        <h5 class="text-danger">Total Pengeluaran</h5>
                        <h3>Rp {{ number_format($total_pengeluaran) }}</h3>
                    </div>
                </div>
            </div>

            <!-- LABA -->
            <div class="col-md-4">
                <div class="card border-primary shadow-sm">
                    <div class="card-body">
                        <h5 class="text-primary">Laba / Rugi</h5>
                        <h3 class="{{ $laba >= 0 ? 'text-success' : 'text-danger' }}">
                            Rp {{ number_format($laba) }}
                        </h3>
                    </div>
                </div>
            </div>

        </div>



        <!-- TABEL PEMASUKAN -->
        <div class="card bg-primary shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Daftar Pemasukan</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->pemasukan as $i => $p)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>Rp {{ number_format($p->nominal) }}</td>
                                <td>{{ $p->keterangan }}</td>
                                <td>{{ $p->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <!-- TABEL PENGELUARAN -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Daftar Pengeluaran</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->pengeluaran as $i => $p)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>Rp {{ number_format($p->nominal) }}</td>
                                <td>{{ $p->keterangan }}</td>
                                <td>{{ $p->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <!-- TABEL KRU -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Daftar Kru Event</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Kru</th>
                            <th>Tanggal Ditambahkan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->kru as $i => $k)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $k->user->name }}</td>
                                <td>{{ $k->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>


    {{-- ===================== MODAL TAMBAH PEMASUKAN ====================== --}}
    <div class="modal fade" id="modalPemasukan">
        <div class="modal-dialog">
            <form action="{{ route('event.pemasukan', $event->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Tambah Pemasukan</h5>
                    </div>
                    <div class="modal-body">
                        <label>Nominal</label>
                        <input type="number" class="form-control" name="nominal" required>

                        <label class="mt-3">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    {{-- ===================== MODAL TAMBAH PENGELUARAN ====================== --}}
    <div class="modal fade" id="modalPengeluaran">
        <div class="modal-dialog">
            <form action="{{ route('event.pengeluaran', $event->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Tambah Pengeluaran</h5>
                    </div>
                    <div class="modal-body">
                        <label>Nominal</label>
                        <input type="number" class="form-control" name="nominal" required>

                        <label class="mt-3">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    {{-- ===================== MODAL TAMBAH KRU ====================== --}}
    <div class="modal fade" id="modalKru">
        <div class="modal-dialog">
            <form action="{{ route('event.kru', $event->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah Kru</h5>
                    </div>
                    <div class="modal-body">
                        <label>Pilih Kru</label>
                        <select class="form-control" name="user_id" required>
                            <option value="">-- Pilih Kru --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (Popper included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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

@endsection
