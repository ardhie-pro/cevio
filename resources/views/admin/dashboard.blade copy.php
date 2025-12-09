<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar shadow-sm" id="sidebar">
        <div class="brand px-2">
            <!-- Jika mau pakai logo, uncomment tag <img> di bawah lalu hapus comment ini. -->
            <!-- <img src="/path/to/logo.png" alt="Logo" style="height:36px; width:auto;"> -->
            <div>
                <div class="brand-text">Admin Dashboard</div>
                <small class="muted">Control panel</small>
            </div>
        </div>

        <nav class="nav flex-column px-1">
            <a class="nav-link active" href="#"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            <a class="nav-link" href="#"><i class="bi bi-people me-2"></i> Users</a>
            <a class="nav-link" href="#"><i class="bi bi-folder me-2"></i> Projects</a>
            <a class="nav-link" href="#"><i class="bi bi-table me-2"></i> Reports</a>
            <a class="nav-link" href="#"><i class="bi bi-gear me-2"></i> Settings</a>
        </nav>

        <div class="mt-auto px-2" style="position:absolute; bottom:20px; left:12px; right:12px;">
            <small class="muted">Logged in as</small>
            <div class="d-flex align-items-center gap-2 mt-1">
                <div class="avatar"></div>
                <div>
                    <div style="font-weight:600">Admin</div>
                    <small class="muted">admin@example.com</small>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main" id="main">
        <div class="topbar">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-secondary d-lg-none" id="btnToggleSidebar">☰</button>
                <h4 class="m-0">Dashboard</h4>
                <small class="muted ms-2">Overview & statistics</small>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="input-group d-none d-md-flex" style="min-width:220px;">
                    <input type="text" class="form-control form-control-sm" placeholder="Search...">
                    <button class="btn btn-sm btn-outline-secondary">Go</button>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="text-end me-2 d-none d-sm-block">
                        <div style="font-weight:700">Ardhie</div>
                        <small class="muted">Super Admin</small>
                    </div>
                    <div class="avatar"></div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card card-lg p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <small class="muted">Total Users</small>
                                <h5 class="mb-0">1,234</h5>
                            </div>
                            <div class="text-end">
                                <small class="muted">+12% (30d)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card card-lg p-3">
                        <small class="muted">Active Projects</small>
                        <h5 class="mb-0">24</h5>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card card-lg p-3">
                        <small class="muted">Open Tickets</small>
                        <h5 class="mb-0">7</h5>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card card-lg p-3">
                        <small class="muted">Revenue</small>
                        <h5 class="mb-0">$12,400</h5>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-12 col-lg-8">
                    <div class="card card-lg p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Activity</h6>
                            <small class="muted">Last 30 days</small>
                        </div>
                        <div style="height:220px; display:flex; align-items:center; justify-content:center;"
                            class="muted">
                            <!-- Placeholder chart. Replace with charting library (Chart.js / Apex) if needed -->
                            <div>-- chart placeholder --</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card card-lg p-3">
                        <h6 class="mb-2">Quick Actions</h6>
                        <div class="d-grid gap-2">
                            <button class="btn btn-sm btn-primary">New User</button>
                            <button class="btn btn-sm btn-outline-primary">New Project</button>
                            <button class="btn btn-sm btn-outline-secondary">Generate Report</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-12">
                    <div class="card card-lg p-3">
                        <h6 class="mb-3">Recent Users</h6>
                        <div class="table-responsive-card">
                            <table class="table table-borderless align-middle mb-0">
                                <thead>
                                    <tr class="text-muted small">
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Joined</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><strong>Budi</strong></td>
                                        <td>budi@example.com</td>
                                        <td>Editor</td>
                                        <td>2025-05-10</td>
                                        <td><button class="btn btn-sm btn-outline-secondary">Details</button></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><strong>Siti</strong></td>
                                        <td>siti@example.com</td>
                                        <td>Author</td>
                                        <td>2025-05-08</td>
                                        <td><button class="btn btn-sm btn-outline-secondary">Details</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="mt-4 text-center small muted">© 2025 Nurdian Group</footer>
        </div>
    </main>

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
</body>

</html>
