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
        <div class="wrapper card card-animate mt-5">
            <div class="title mb-5">Daftar Soal -----</div>
            {{-- Alert sukses --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <button type="button" class="btn btn-answered col-2 mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                + Tambah Kolom Soal
            </button>
            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                style="
                                                    border-collapse: collapse;
                                                    border-spacing: 0;
                                                    width: 100%;
                                                ">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        @for ($i = 1; $i <= 5; $i++)
                            <th>Soal {{ $i }}</th>
                        @endfor
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->judul }}</td>

                            @for ($i = 1; $i <= 5; $i++)
                                <td>
                                    @if ($item["soal{$i}_text"])
                                        <p class="mb-1">{{ $item["soal{$i}_text"] }}</p>
                                    @endif

                                    @if ($item["soal{$i}_img"])
                                        <img src="{{ asset('storage/' . $item["soal{$i}_img"]) }}"
                                            alt="soal{{ $i }}" class="img-thumbnail" width="80">
                                    @endif
                                </td>
                            @endfor

                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-warning btn-edit"
                                    data-id="{{ $item->id }}">
                                    Edit
                                </button>

                                <form action="{{ route('kelompok-soal.destroy', $item->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data kolom soal.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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

    {{-- ===================== END MODAL TAMBAH ===================== --}}
    {{-- ===================== MODAL EDIT ===================== --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="modalEditLabel">Edit Kolom Soal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formEdit" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="judul" id="edit_judul" class="form-control">
                        </div>

                        @for ($i = 1; $i <= 5; $i++)
                            <div class="border rounded p-3 mb-3">
                                <h5>Soal {{ $i }}</h5>

                                <div class="mb-2">
                                    <label class="form-label">Teks Soal
                                        {{ $i }}</label>
                                    <textarea name="soal{{ $i }}_text" id="edit_soal{{ $i }}_text" class="form-control"
                                        rows="2"></textarea>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Gambar Soal
                                        {{ $i }}</label>
                                    <input type="file" name="soal{{ $i }}_img" class="form-control">
                                    <div id="edit_soal{{ $i }}_preview" class="mt-2"></div>
                                </div>
                            </div>
                        @endfor
                    </div>

                    <div class="modal-footer" style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ===================== END MODAL EDIT ===================== --}}

    </div>
    <!-- Container-Fluid -->
    </div>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));

            // Ketika tombol edit ditekan
            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;

                    fetch(`/kelompok-soal/${id}/edit`)
                        .then(res => res.json())
                        .then(data => {
                            // Isi form modal edit dengan data dari server
                            document.getElementById('formEdit').action = `/kelompok-soal/${id}`;
                            document.getElementById('edit_judul').value = data.judul ?? '';

                            for (let i = 1; i <= 5; i++) {
                                document.getElementById(`edit_soal${i}_text`).value = data[
                                    `soal${i}_text`] ?? '';

                                const preview = document.getElementById(
                                    `edit_soal${i}_preview`);
                                if (data[`soal${i}_img`]) {
                                    preview.innerHTML =
                                        `<img src="/storage/${data[`soal${i}_img`]}" width="100" class="img-thumbnail">`;
                                } else {
                                    preview.innerHTML = '';
                                }
                            }

                            modalEdit.show(); // 🔥 tampilkan modal form edit
                        })
                        .catch(err => console.error('Gagal ambil data:', err));
                });
            });
        });
    </script>
@endsection
