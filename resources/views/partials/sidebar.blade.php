<style>
    /* Container */
    .vertical-menu {
        background: #0E2542 !important;
        padding: 10px !important;
    }

    /* Item menu utama */
    #side-menu>li>a {
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        padding: 12px 16px !important;
        margin-bottom: 8px !important;
        background: #183E6F !important;
        border-radius: 10px !important;
        color: #ffffff !important;
        font-weight: 500 !important;
        transition: all .2s ease !important;
    }

    /* Hover kuning */
    #side-menu>li>a:hover {
        background: #F4C542 !important;
        color: #0E2542 !important;
        transform: translateX(4px) !important;
    }

    /* Aktif */
    #side-menu>li>a.active {
        background: #F4C542 !important;
        color: #0E2542 !important;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15) !important;
    }

    .submenu a.active {
        background: #F4C542 !important;
        color: #0E2542 !important;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15) !important;
    }

    /* Icon mengikuti warna text */
    #side-menu li a i {
        color: inherit !important;
    }

    /* Submenu */
    .submenu {
        display: none !important;
        padding-left: 16px !important;
        margin-top: 6px !important;
    }

    .submenu a {
        display: block !important;
        padding: 10px 14px !important;
        margin-bottom: 6px !important;
        background: #1b4479 !important;
        color: #ffffff !important;
        border-radius: 8px !important;
        transition: .2s !important;
    }

    /* Submenu hover */
    .submenu a:hover {
        background: #F4C542 !important;
        color: #0E2542 !important;
    }

    /* Show submenu */
    li.open .submenu {
        display: block !important;
    }

    /* Parent menu ketika active */
    .has-dropdown.active>a {
        background: #F4C542 !important;
        color: #0E2542 !important;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15) !important;
    }

    /* Jika class open → submenu muncul */
    .has-dropdown.open .submenu {
        display: block !important;
    }
</style>
<div class="vertical-menu">

    <div data-simplebar class="h-100">



        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            @php
                $user = Auth::user();
            @endphp

            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Main</li>

                @if ($user && $user->status === 'admin')
                    <li>
                        <a href="{{ route('admin.index') }}" class="{{ Route::is('dashboard.*') ? 'active' : '' }}">
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li
                        class="has-dropdown {{ Route::is('admin.akun') || Route::is('admin.user') ? 'active open' : '' }}">
                        <a href="#">
                            <i class="mdi">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                                </svg>
                            </i>
                            <span>Akun</span>
                        </a>

                        <div class="submenu {{ Route::is('admin.akun') || Route::is('admin.user') ? 'show' : '' }}">
                            <a href="{{ route('admin.akun') }}" class="{{ Route::is('admin.akun') ? 'active' : '' }}">
                                Admin / Review
                            </a>

                            <a href="{{ route('admin.user') }}" class="{{ Route::is('admin.user') ? 'active' : '' }}">
                                User
                            </a>
                        </div>
                    </li>
                    <!-- Dropdown 1 -->
                    </li>



                    <li
                        class="has-dropdown
    {{ Route::is('tarik-modul.index') || Route::is('grupangkahilang.index') ? 'active open' : '' }}">
                        <a href="#">
                            <i class="mdi mdi-download-box-outline"></i>
                            <span>Soal</span>
                        </a>

                        <div
                            class="submenu
        {{ Route::is('tarik-modul.index') || Route::is('grupangkahilang.index') ? 'show' : '' }}">

                            <a href="{{ route('tarik-modul.index', ['type' => 'data-nama,istirahat,panduan']) }}"
                                class="{{ request('type') === 'data-nama,istirahat,panduan' ? 'active' : '' }}">
                                Lainya
                            </a>

                            <a href="{{ route('tarik-modul.index', ['type' => 'multiple-chois']) }}"
                                class="{{ request('type') === 'multiple-chois' ? 'active' : '' }}">
                                Multiple Choice
                            </a>

                            {{-- <a href="{{ route('tarik-modul.index', ['type' => 'angka-hilang']) }}"
                                class="{{ request('type') === 'angka-hilang' ? 'active' : '' }}">
                                Soal Angka Hilang
                            </a> --}}

                            <a href="{{ route('tarik-modul.index', ['type' => 'tanpa-kembali']) }}"
                                class="{{ request('type') === 'tanpa-kembali' ? 'active' : '' }}">
                                Tanpa Kembali
                            </a>

                            {{-- MENU BARU: GRUP ANGKA HILANG --}}
                            <a href="{{ route('grupangkahilang.index') }}"
                                class="{{ Route::is('grupangkahilang.index') ? 'active' : '' }}">
                                Grup Angka Hilang
                            </a>

                        </div>
                    </li>


                    <!-- Dropdown 2 -->
                    <li>
                        <a href="{{ route('kumpulan-modul.index') }}"
                            class="{{ Route::is('kumpulan-modul.*') ? 'active' : '' }}">
                            <i class="mdi mdi-file-multiple-outline"></i>
                            <span>Centang Modul</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('generate-kode.index') }}"
                            class="{{ Route::is('generate-kode.*') ? 'active' : '' }}">
                            <i class="mdi mdi-qrcode-edit"></i>
                            <span>Generate Kode</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('kelompok-soal.index') }}"
                            class="{{ Route::is('kelompok-soal.*') ? 'active' : '' }}">
                            <i class="mdi mdi-format-list-bulleted"></i>
                            <span>Kolom Soal</span>
                        </a>
                    </li> --}}

                    <li>
                        <a href="{{ route('laporan.index') }}" class="{{ Route::is('laporan.*') ? 'active' : '' }}">
                            <i class="mdi mdi-file-chart"></i>
                            <span>Laporan</span>
                        </a>
                    </li>
                @endif

                @if ($user && $user->status === 'review')
                    <li>
                        <a href="{{ route('tampilkankode.index') }}"
                            class="{{ Route::is('tampilkankode.*') ? 'active' : '' }}">
                            <i class="mdi mdi-eye-check-outline"></i>
                            <span>Histori</span>
                        </a>
                        <a href="{{ route('review.index') }}" class="{{ Route::is('review.*') ? 'active' : '' }}">
                            <i class="mdi mdi-file-chart"></i>
                            <span>Data Akun</span>
                        </a>
                    </li>
                @endif
            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
<script>
    document.querySelectorAll(".has-dropdown > a").forEach(btn => {
        btn.addEventListener("click", function(e) {
            e.preventDefault();

            const li = this.parentElement;
            li.classList.toggle("open");
        });
    });
</script>
