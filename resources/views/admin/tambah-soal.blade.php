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
        {{-- =====================  TABEL REVIEW  ===================== --}}
        <div class="wrapper" id="editFormContainer" style="display:none;">
            <form id="formEditSoal" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="modul" id="editModul">
                <div class="mb-3">
                    <label>No Soal</label>
                    <input type="text" name="no" class="form-control" id="editNo" required>
                </div>

                <div class="mb-3">
                    <label>Kolom</label>
                    <select name="kelompok" class="form-control" id="editKelompok" required>
                        <option value="">-- Pilih Kolom --</option>
                        @foreach ($kelompok as $k)
                            <option value="{{ $k->judul }}">{{ $k->judul }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Soal</label>
                    <textarea name="soal2" class="form-control" id="editSoal" rows="3"></textarea>
                </div>

                @for ($i = 1; $i <= 5; $i++)
                    <div class="mb-3">
                        <label>Gambar J{{ $i }} (Opsional)</label>
                        <input type="file" name="j{{ $i }}" class="form-control">
                    </div>
                @endfor

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
        <div class="wrapper card card-animate mt-5">
            <div class="title mb-5">Daftar Soal -----</div>

            <div class="d-flex gap-2 mb-3">
                <button class="btn btn-warning col-2" data-bs-toggle="modal" data-bs-target="#addModal">
                    + Tambah Soal
                </button>

                <button type="button" class="btn btn-answered col-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    + Tambah Kolom Soal
                </button>
            </div>

            {{-- Alert sukses --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif


            <script>
                document.addEventListener("DOMContentLoaded", function() {

                    // 🔹 Fungsi untuk menampilkan form edit dan isi otomatis
                    window.showEditForm = function(id, modul, kelompok, soal, no) {
                        const formContainer = document.getElementById('editFormContainer');
                        const form = document.getElementById('formEditSoal');

                        // tampilkan form edit
                        formContainer.style.display = 'block';

                        // isi data
                        document.getElementById('editModul').value = modul;
                        document.getElementById('editNo').value = no; // kalau id bukan no, ubah nanti
                        document.getElementById('editKelompok').value = kelompok;
                        document.getElementById('editSoal').value = soal;

                        // ubah action ke route update
                        form.action = `/soal/${id}`;
                    };

                    // 🔹 Fungsi untuk batal edit
                    window.cancelEdit = function() {
                        document.getElementById('editFormContainer').style.display = 'none';
                        document.getElementById('formEditSoal').reset();
                    };
                });
            </script>

            @php
                // Ambil data kelompok yang sesuai dengan modul terpilih
                $selected = $kelompok->where('persamaan', $modul)->first();

                // Default kosong
                $list = [
                    ['key' => 'A', 'text' => null, 'img' => null],
                    ['key' => 'B', 'text' => null, 'img' => null],
                    ['key' => 'C', 'text' => null, 'img' => null],
                    ['key' => 'D', 'text' => null, 'img' => null],
                    ['key' => 'E', 'text' => null, 'img' => null],
                ];

                // Jika ditemukan kelompok yang cocok, ambil datanya
                if ($selected) {
                    $list = [
                        ['key' => 'A', 'text' => $selected->soal1_text ?? null, 'img' => $selected->soal1_img ?? null],
                        ['key' => 'B', 'text' => $selected->soal2_text ?? null, 'img' => $selected->soal2_img ?? null],
                        ['key' => 'C', 'text' => $selected->soal3_text ?? null, 'img' => $selected->soal3_img ?? null],
                        ['key' => 'D', 'text' => $selected->soal4_text ?? null, 'img' => $selected->soal4_img ?? null],
                        ['key' => 'E', 'text' => $selected->soal5_text ?? null, 'img' => $selected->soal5_img ?? null],
                    ];
                }
            @endphp


            <style>
                /* CONTAINER UTAMA */
                .kolom-wrapper {
                    background: #e1b63b !important;
                    color: #0E2542 !important;
                    padding: 25px;
                    border-radius: 12px;
                    border: 2px solid #0E2542;
                    margin-bottom: 25px;
                }

                /* JUDUL */
                .kolom-title {
                    width: 100%;
                    background: white;
                    border: 2px solid #0E2542;
                    border-radius: 10px;
                    padding: 12px;
                    font-size: 34px;
                    /* DIGEDEKAN */
                    font-weight: 900;
                    text-align: center;
                    margin-bottom: 25px;
                    color: #0E2542;
                }

                /* WRAPPER KOTAK OPSI */
                .opsi-container {
                    display: flex;
                    justify-content: space-between;
                    gap: 20px;
                }

                /* KOTAK UTAMA PUTIH */
                .opsi-box {
                    flex: 1;
                    height: 150px;
                    background: white;
                    border: 2px solid #0E2542;
                    border-radius: 10px;
                    padding: 10px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }

                /* GAMBAR */
                .opsi-img {
                    max-height: 130px;
                    max-width: 100%;
                }

                /* LABEL A–E */
                .opsi-label {
                    width: 100%;
                    border: 2px solid #0E2542;
                    /* BORDER BIRU */
                    border-radius: 10px;
                    /* ROUNDED SAMA */
                    padding: 5px;
                    margin-top: 8px;
                    font-weight: 800;
                    font-size: 22px;
                    /* DIGEDEKAN */
                    text-align: center;
                    color: #ffffffff;
                    background: #0E2542;
                }
            </style>



            <tbody id="tbody-kelompok">
                <tr>
                    <td colspan="9">
                        <div class="kolom-wrapper">
                            <div class="row ">
                                <div class="col-2 mt-3 mb-5 p-2 ">
                                    @if ($selected)
                                        <form action="{{ route('kelompok-soal.destroy', $selected->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    Hapus
                                                </button>
                                            </div>

                                        </form>
                                    @endif
                                </div>
                                <div class="col-2 mt-3 mb-5  p-2 ms-auto"> <!-- Tambah ms-auto -->
                                    <form action="{{ route('soal.generate') }}" method="POST">
                                        @csrf

                                        <input type="hidden" name="modul" value="{{ $modul }}">
                                        <input type="hidden" name="kelompok" value="{{ $selected->judul ?? '' }}">

                                        <div class="d-flex align-items-center gap-2">
                                            <input type="number" name="jumlah" id="jumlah" placeholder="Jumlah"
                                                min="1" class="form-control" required
                                                style="background-color: white !important; color: black;">

                                            <button type="submit" class="btn btn-success">
                                                Generate
                                            </button>
                                        </div>

                                    </form>
                                </div>



                            </div>




                            {{-- JUDUL --}}
                            <div class="kolom-title">
                                {{ $selected->judul ?? '' }}
                            </div>

                            {{-- OPSI --}}
                            <div class="opsi-container">
                                @foreach ($list as $item)
                                    <div style="flex:1;">

                                        {{-- KOTAK --}}
                                        <div class="opsi-box">
                                            @if ($item['text'])
                                                <h1>{{ $item['text'] }}</h1>
                                            @else
                                                @if ($item['img'])
                                                    <img src="{{ asset('storage/' . $item['img']) }}" class="opsi-img">
                                                @else
                                                    -
                                                @endif
                                            @endif
                                        </div>

                                        {{-- LABEL A–E --}}
                                        <div class="opsi-label">{{ $item['key'] }}</div>

                                    </div>
                                @endforeach
                            </div>

                        </div>

                    </td>
                </tr>
            </tbody>

            <form id="formDeleteAll" action="{{ route('soal.deleteAll') }}" method="POST">
                @csrf
                <input type="hidden" name="type_template" value="{{ $type_template }}">

                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                    style="
                                                    border-collapse: collapse;
                                                    border-spacing: 0;
                                                    width: 100%;
                                                ">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll"></th>
                            <th>NO</th>
                            <th>Kelompok Soal</th>
                            <th>Soal</th>
                            <th>Gambar 1</th>
                            <th>Gambar 2</th>
                            <th>Gambar 3</th>
                            <th>Gambar 4</th>
                            <th>Gambar 5</th>
                            <th>Aksi</th>

                        </tr>
                    </thead>


                    <tbody id="tbody-soal-biasa">
                        @foreach ($data as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="checkItem">

                                </td>
                                <td>{{ $item->no }}</td>
                                <td>{{ $item->kelompok }}</td>
                                <td>{{ $item->soal2 ?? '-' }}</td>

                                <td>
                                    @if ($item->j1)
                                        <img src="{{ asset('storage/' . $item->j1) }}" width="60">
                                    @endif
                                </td>
                                <td>
                                    @if ($item->j2)
                                        <img src="{{ asset('storage/' . $item->j2) }}" width="60">
                                    @endif
                                </td>
                                <td>
                                    @if ($item->j3)
                                        <img src="{{ asset('storage/' . $item->j3) }}" width="60">
                                    @endif
                                </td>
                                <td>
                                    @if ($item->j4)
                                        <img src="{{ asset('storage/' . $item->j4) }}" width="60">
                                    @endif
                                </td>
                                <td>
                                    @if ($item->j5)
                                        <img src="{{ asset('storage/' . $item->j5) }}" width="60">
                                    @endif
                                </td>

                                <td>
                                    <button type="button" class="btn btn-warning btn-sm"
                                        onclick="showEditForm('{{ $item->id }}', '{{ $item->modul }}', '{{ $item->kelompok }}', `{{ $item->soal2 }}`, `{{ $item->no }}`)">
                                        Edit
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="deleteSingle({{ $item->id }})">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>


                </table>
                <button type="button" id="btnDeleteSelected" class="btn btn-danger mt-2">
                    Hapus Terpilih
                </button>
            </form>

        </div>


    </div>
    {{-- ===================== MODAL TAMBAH ===================== --}}

    <!-- Modal Tambah -->
    <!-- Modal Tambah -->
    <div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Soal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('soal.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="modul" value="{{ $modul }}">
                        <div class="mb-3">
                            <label>No Soal</label>
                            <input type="text" name="no" class="form-control" required>
                            <input type="hidden" name="kelompok" class="form-control"
                                value="{{ $selected->judul ?? '' }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Soal</label>
                            <textarea name="soal2" class="form-control"></textarea>
                        </div>
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="mb-3">
                                <label>Gambar J{{ $i }} (Opsional)</label>
                                <input type="file" name="j{{ $i }}" class="form-control">
                            </div>
                        @endfor
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- ===================== MODAL TAMBAH ===================== --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Kolom Soal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ url('/kelompok-soal') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="judul" class="form-control">
                            <input type="hidden" name="persamaan" value="{{ $modul }}">
                        </div>

                        @for ($i = 1; $i <= 5; $i++)
                            <div class="border rounded p-3 mb-3">
                                <h5>Soal {{ $i }}</h5>

                                <div class="mb-2">
                                    <label class="form-label">Teks Soal
                                        {{ $i }}</label>
                                    <textarea name="soal{{ $i }}_text" class="form-control" rows="2"></textarea>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Gambar Soal
                                        {{ $i }}</label>
                                    <input type="file" name="soal{{ $i }}_img" class="form-control">
                                </div>
                            </div>
                        @endfor
                    </div>

                    <div class="modal-footer " style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // ===========================
        // CENTANG SEMUA
        // ===========================
        document.getElementById('checkAll').addEventListener('change', function() {
            document.querySelectorAll('.checkItem').forEach(cb => cb.checked = this.checked);
        });

        // ===========================
        // HAPUS TERPILIH
        // ===========================
        document.getElementById('btnDeleteSelected').addEventListener('click', function() {

            let checked = document.querySelectorAll('.checkItem:checked');

            if (checked.length === 0) {
                alert("Tidak ada data yang dipilih!");
                return;
            }

            // hanya konfirmasi biasa tanpa tampilkan ID
            if (confirm("Yakin ingin menghapus data yang dipilih?")) {
                document.getElementById('formDeleteAll').submit();
            }
        });

        // ===========================
        // HAPUS SATU DATA
        // ===========================
        function deleteSingle(id) {

            if (!confirm("Yakin hapus data ini?")) return;

            // form delete dinamis (anti nested form)
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/soal/' + id;

            form.innerHTML = `
        @csrf
        @method('DELETE')
    `;

            document.body.appendChild(form);
            form.submit();
        }
    </script>



@endsection
