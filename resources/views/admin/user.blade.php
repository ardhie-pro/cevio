@extends('layouts.main-page')

@section('title', 'Dashboard')

@section('content4')




    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- input grup --}}
    {{-- input user  --}}
    {{-- <div class="wrapper mt-5">
            <div class="title">Input Grup</div>
            @if (session('successgrup'))
                <div class="alert alert-success">{{ session('successgrup') }}</div>
            @endif

            <form action="{{ route('user.buatgrup') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama Grup</label>
                    <input type="text" name="nama_grup" class="form-control">
                </div>

                <button class="btn btn-primary">Simpan</button>
            </form>

            <div class="mt-4 p-2 bg-light rounded-1">
                @foreach ($grup as $g)
                    <form action="{{ route('user.hapusgrup', $g->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')

                        <span class="badge bg-dark p-2 m-2">
                            {{ $g->nama_grup }}
                            <button class="btn btn-sm btn-danger p-0 px-1" style="margin-left:5px; font-size:10px;"
                                onclick="return confirm('Hapus grup ini?')">
                                ✕
                            </button>
                        </span>
                    </form>
                @endforeach
            </div>

        </div>

        <div class="wrapper">
            <div class="title">Daftar Grup</div>

            <select id="pilihGrup" class="form-select mb-3" onchange="filterByGrup()">
                <option value="">-- Pilih Grup --</option>
                @foreach ($grup as $g)
                    <option value="{{ $g->nama_grup }}">{{ $g->nama_grup }}</option>
                @endforeach
            </select>

            <div id="listUser"></div>
        </div> --}}
    <div class="card p-5 mt-5">
        <h3 class="title mb-5">Input User</h3>
        <form action="{{ route('user.buatakun') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label>Status / Role</label>
                <select name="status" class="form-control">
                    <option value="manajer">Manajer</option>
                    <option value="project-manajer">Project-Manajer</option>
                    <option value="kru">Kru</option>
                </select>
            </div>
            {{-- <div class="mb-3">
                <label>Grup</label>
                <select name="grup" class="form-control">
                    <option value="-">tidak ada grup</option>
                    @foreach ($grup as $g)
                        <option value="{{ $g->nama_grup }}">{{ $g->nama_grup }}</option>
                    @endforeach
                </select>
            </div> --}}
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>


    <script>
        // gabungkan dan reset index
        const dataUser = @json($userb->values()->merge($userb->values()));
        console.log(dataUser); // debug

        function filterByGrup() {
            const grup = document.getElementById("pilihGrup").value;
            console.log("Grup dipilih:", grup); // debug

            const filtered = dataUser.filter(u => u.grup == grup);
            console.log("Filtered:", filtered); // debug

            let html = "";

            if (filtered.length === 0) {
                html = "<p class='text-muted'>Tidak ada user di grup ini.</p>";
            } else {
                html += `
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>`;

                filtered.forEach(function(u) {
                    html += `
                    <tr>
                        <td>${u.name}</td>
                        <td>${u.email}</td>
                        <td>
                            <form action="/user/hapus-grup/${u.id}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button class="btn btn-danger btn-sm">Hapus Grup</button>
                            </form>
                        </td>
                    </tr>`;
                });

                html += `</tbody></table>`;
            }

            document.getElementById("listUser").innerHTML = html;
        }
    </script>
    {{-- <div class="wrapper">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.generateUser') }}" method="POST">
            @csrf
            <label>Jumlah User yang Ingin Dibuat:</label>
            <input type="number" name="jumlah" class="form-control" required>
            <button type="submit" class="btn btn-primary mt-2">Generate</button>
        </form>
    </div> --}}

    @if (isset($hasil) && count($hasil) > 0)
        <div class="wrapper ">
            <h3 class="mt-4">Hasil Generate User</h3>
            <table id="tabelHasil" class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password (Asli)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hasil as $i => $u)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->lihatpw }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    @endif

    {{-- =====================  TABEL ADMIN  ===================== --}}
    <div class="card p-5">
        <div class="title">Informasi Akun — User</div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead style="background:#F4C542; color:#0E2542; font-weight:700;">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Status</th>
                        {{-- <th>Grup</th> --}}
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @php $noAdmin = 1; @endphp

                    @foreach ($userb as $user)
                        <tr>
                            <td>{{ $noAdmin++ }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->lihatpw }}</td>
                            <td> <a href="{{ route('user.detail', $user->id) }}" class="btn btn-info btn-sm">
                                    Detail
                                </a></td>


                            <td>
                                <form action="{{ route('admin.updateUser', $user->id) }}" method="POST">
                                    @csrf
                                    <select name="role" class="form-select form-select-sm">
                                        <option value="active" {{ $user->role == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ $user->role == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                        <option value="suspended" {{ $user->role == 'suspended' ? 'selected' : '' }}>
                                            Suspended</option>
                                    </select>
                            </td>

                            <td>
                                <select name="status" class="form-select form-select-sm">
                                    <option value="user" {{ $user->status == 'manajer' ? 'selected' : '' }}>Manjer
                                    </option>
                                    <option value="review" {{ $user->status == 'project-manajer' ? 'selected' : '' }}>
                                        Project Manajer
                                    </option>
                                    <option value="admin" {{ $user->status == 'kru' ? 'selected' : '' }}>Kru
                                    </option>

                                </select>
                            </td>

                            {{-- <td> --}}
                            {{-- <select name="grup" class="form-select form-select-sm"> --}}

                            {{-- Option untuk grup kosong --}}
                            {{-- <option value=""
                                        {{ empty($user->grup) || $user->grup == '-' ? 'selected' : '' }}>
                                        Tidak Ada
                                    </option> --}}

                            {{-- List grup lainnya --}}
                            {{-- @foreach ($grup as $g)
                                        <option value="{{ $g->nama_grup }}"
                                            {{ $user->grup == $g->nama_grup ? 'selected' : '' }}>
                                            {{ $g->nama_grup }}
                                        </option>
                                    @endforeach --}}

                            {{-- </select> --}}
                            {{-- </td> --}}



                            <td>
                                <button type="submit" class="btn btn-warning btn-sm mb-2">💾</button>
                                </form>

                                <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin mau hapus user ini?')">
                                        🗑️
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- =====================  TABEL REVIEW  ===================== --}}

    </div>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <!-- JSZip (untuk Excel) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- PDFMake (untuk PDF) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script>
        $(document).ready(function() {
            $('#tabelHasil').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy',
                    'excel',
                    'pdf',
                    'print'
                ]
            });
        });
    </script>


@endsection
