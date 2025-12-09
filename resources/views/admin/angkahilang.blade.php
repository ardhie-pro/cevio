@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <style>
        body {
            background: #f4f6fb;
            padding: 0;
            font-family: "Inter", Arial, sans-serif;
        }

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

        /* form edit */
        .edit-box {
            padding: 20px;
            background: #f9fbff;
            border: 1px solid #d8dce5;
            border-radius: 10px;
            margin-top: 15px;
            display: none;
            animation: slide 0.2s ease-out;
        }

        @keyframes slide {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .bg-birucibn {
            background-color: #244e9b;
        }

        .btn-answered {
            background-color: #244e9b;
            color: white;
        }
    </style>

    <div class="page-content">

        <div class="wrapper card card-animate mt-5">
            <div class="title mb-4">Daftar Grup -----</div>

            <button class="btn btn-answered col-2 mb-5" data-bs-toggle="modal" data-bs-target="#addModal">
                Tambah Grup
            </button>



            <div class="row g-3">
                @foreach ($data as $g)
                    <div class="col-md-4">

                        <div class="card bg-birucibn p-3 text-light shadow-sm">
                            <h5>
                                <a href="{{ route('grup.detail', $g->nama_grup) }}"
                                    style="color: white; text-decoration: none;">
                                    {{ $g->nama_grup }}
                                </a>
                            </h5>


                            <div class="d-flex justify-content-end gap-2 mt-2">
                                <!-- EDIT -->
                                <a class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $g->id }}">
                                    <i class="bx bx-edit"></i>
                                </a>

                                <!-- DELETE -->
                                <form action="{{ route('grup.destroy', $g->nama_grup) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus bang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @foreach ($data as $g)
            @endforeach

            {{-- TARUH SEMUA MODAL DI SINI --}}
            @foreach ($data as $g)
                <div class="modal fade" id="editModal{{ $g->id }}">
                    <div class="modal-dialog">
                        <form action="{{ route('grup.update', $g->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5>Edit Nama Grup</h5>
                                </div>
                                <div class="modal-body">
                                    <input type="text" name="nama_grup" class="form-control" value="{{ $g->nama_grup }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>

                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach



        </div>
    </div>

    {{-- SCRIPT UNTUK TOGGLE FORM EDIT --}}
    <script>
        function toggleEdit(id) {
            // sembunyikan semua form edit dulu
            document.querySelectorAll('.edit-box').forEach(el => el.style.display = 'none');

            // toggle hanya yang diklik
            const box = document.getElementById('formEdit' + id);
            box.style.display = (box.style.display === 'none' || box.style.display === '') ? 'block' : 'none';
        }
    </script>


    <!-- MODAL TAMBAH DATA (TETAP ADA) -->
    <div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('grupkolom.generate') }}" method="POST">
                        @csrf
                        <label>Nama Grup:</label>
                        <input type="text" name="nama_grup" class="form-control" required>

                        <label>Jumlah Generate:</label>
                        <input type="number" name="jumlah" class="form-control" required>

                        <label>Waktu (detik):</label>
                        <input type="number" name="waktu" class="form-control" required>

                        <button type="submit" class="btn btn-answered mt-5">Generate</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
