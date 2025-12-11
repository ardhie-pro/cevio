<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assetts/images/favicon.ico') }}">

    <!-- DataTables -->
    <link href="{{ asset('assetts/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assetts/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assetts/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assetts/css/code.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('assetts/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assetts/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assetts/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
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
            <div>
                <div class="brand-text">Admin Dashboard</div>
                <small class="muted">Control panel</small>
            </div>
        </div>

        <nav class="nav flex-column px-1">
            <a class="nav-link active"
                href="{{ route(
                    auth()->user()->status == 'manajer'
                        ? 'event.index'
                        : (auth()->user()->status == 'project-manajer'
                            ? 'event.index'
                            : (auth()->user()->status == 'kru'
                                ? 'kru.index'
                                : 'event.index')),
                ) }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            @if (auth()->user()->status == 'manajer')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.user') }}">
                        <i class="bi bi-people"></i> Daftar Anggota
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('role.index') }}">
                        <i class="bi bi-people"></i> Master Role
                    </a>
                </li>
            @endif


            {{-- <a class="nav-link" href="#"><i class="bi bi-people me-2"></i> Users</a>
            <a class="nav-link" href="#"><i class="bi bi-folder me-2"></i> Projects</a>
            <a class="nav-link" href="#"><i class="bi bi-table me-2"></i> Reports</a>

            <!-- SETTINGS DROPDOWN -->
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-gear me-2"></i> Settings
                </a>

                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-person me-2"></i> Profile
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>
                </ul>
            </div> --}}
        </nav>

        <div class="mt-auto px-2" style="position:absolute; bottom:20px; left:12px; right:12px;">
            <small class="muted">Logged in as</small>
            <div class="d-flex align-items-center gap-2 mt-1">
                <div class="avatar"></div>
                <div>
                    <div style="font-weight:600">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <small class="muted">{{ Auth::user()->email ?? 'admin@example.com' }}</small>
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

                <div class="d-flex align-items-center gap-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>


        @yield('content4')



    </main>

    <!-- Bootstrap JS (Popper included) -->


    <!-- DATATABLES CSS -->
    <script src="{{ asset('assetts/libs/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
        $("#role_id").on("change", function() {
            let roleID = $(this).val();

            $.get("{{ url('/role') }}/" + roleID + "/shifts", function(data) {
                $("#shift_id").html("<option value=''>-- Pilih Shift --</option>");

                data.forEach(s => {
                    $("#shift_id").append(
                        `<option value="${s.id}" data-fee="${s.fee_per_unit}">
                        ${s.jam_mulai} - ${s.jam_selesai} (Rp ${s.fee_per_unit})
                    </option>`
                    );
                });
            });
        });

        $("#shift_id").on("change", function() {
            let fee = $(this).find(":selected").data("fee");
            $("#fee").val(fee);

            let jumlah = $("#jumlah").val();
            $("#total").val(fee * jumlah);
        });

        $("#jumlah").on("input", function() {
            let fee = $("#fee").val();
            $("#total").val(fee * $(this).val());
        });
    </script>


    <script src="{{ asset('assetts/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <!--tinymce js-->
    <script src="{{ asset('assetts/libs/tinymce/tinymce.min.js') }}"></script>

    <!-- init js -->
    {{-- <script src="{{ asset('assetts/js/pages/form-editor.init.js') }}"></script> --}}

    <!-- Required datatable js -->
    <script src="{{ asset('assetts/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assetts/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assetts/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>


    <!-- Responsive examples -->
    <script src="{{ asset('assetts/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ asset('assetts/js/pages/datatables.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assetts/js/app.js') }}"></script>

</body>

</html>
