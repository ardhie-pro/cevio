@extends('layouts.main-page')

@section('title', 'Dashboard')

@section('content4')
    <div class="card p-5 mt-4">
        <div class="row mb-3">
            <div class="col-6">
                <h3>Data Event Anda</h3>
            </div>
            <div class="col-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">Tambah
                    Event</button>
            </div>
        </div>


        <div class="table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap">

                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Event</th>
                        <th>Nama Client</th>
                        <th>Mulai Pelaksanaan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i => $row)
                        {{-- Jika project-manajer, hanya tampilkan event miliknya --}}
                        @if (Auth::user()->status == 'project-manajer' && $row->project_manager != Auth::user()->name)
                            @continue
                        @endif

                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $row->nama_event }}</td>
                            <td>{{ $row->client }}</td>
                            <td>{{ $row->mulai_pelaksanaan }}</td>
                            <td>{{ $row->status }}</td>

                            <td>
                                <a href="{{ route('event.show', $row->id) }}" class="btn btn-sm btn-info">
                                    Detail
                                </a>

                                {{-- Jika bukan manajer (project-manajer boleh), tampilkan tombol edit --}}
                                @if (Auth::user()->status !== 'manajer')
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $row->id }}">
                                        Edit
                                    </button>

                                    <form action="{{ route('event.destroy', $row->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>
    </div>

    <!-- MODAL ADD EVENT -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('event.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">



                            <input type="hidden" name="project_manager" value="{{ Auth::user()->name }}" readonly>


                            <div class="col-12">
                                <label class="form-label">Client</label>
                                <input type="text" name="client" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Nama Event</label>
                                <input type="text" name="nama_event" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Lokasi</label>
                                <input type="text" name="lokasi" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Nilai Project</label>

                                <!-- Input tampilan untuk user -->
                                <input type="text" id="nilai_project_view" class="form-control">

                                <!-- Input asli yang akan dikirim ke server -->
                                <input type="hidden" id="nilai_project" name="nilai_project">
                            </div>




                            <div class="col-6">
                                <label class="form-label">Waktu Mulai Pelaksanaan</label>
                                <input type="datetime-local" id="mulai_pelaksanaan" name="mulai_pelaksanaan"
                                    class="form-control">
                            </div>

                            <div class="col-6">
                                <label class="form-label">Waktu Selesai Pelaksanaan</label>
                                <input type="datetime-local" id="selesai_pelaksanaan" name="selesai_pelaksanaan"
                                    class="form-control">
                            </div>

                            <div class="col-6">
                                <label class="form-label">Waktu Mulai Persiapan</label>
                                <input type="datetime-local" id="mulai_persiapan" name="mulai_persiapan"
                                    class="form-control">
                            </div>

                            <div class="col-6">
                                <label class="form-label">Waktu Selesai Persiapan</label>
                                <input type="datetime-local" id="selesai_persiapan" name="selesai_persiapan"
                                    class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Durasi Pelaksanaan (Jam)</label>
                                <input type="text" id="durasi_pelaksanaan" name="durasi_pelaksanaan" class="form-control"
                                    readonly>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Durasi Persiapan (Jam)</label>
                                <input type="text" id="durasi_persiapan" name="durasi_persiapan" class="form-control"
                                    readonly>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Total Durasi (Jam)</label>
                                <input type="text" id="total_durasi" name="total_durasi" class="form-control"
                                    readonly>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                </div>



            </div>
        </div>
    </div>
    @foreach ($data as $row)
        <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('event.update', $row->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-body">
                            <div class="row g-3">

                                <input type="hidden" name="project_manager" value="{{ Auth::user()->name }}" readonly>

                                <div class="col-12">
                                    <label class="form-label">Client</label>
                                    <input type="text" name="client" value="{{ $row->client }}"
                                        class="form-control">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Nama Event</label>
                                    <input type="text" name="nama_event" value="{{ $row->nama_event }}"
                                        class="form-control">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" name="lokasi" value="{{ $row->lokasi }}"
                                        class="form-control">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Nilai Project</label>

                                    <!-- Input untuk tampilan (diformat) -->
                                    <input type="text" id="nilai_project_view" class="form-control"
                                        value="{{ number_format($row->nilai_project, 0, ',', '.') }}">

                                    <!-- Input hidden untuk dikirim ke server -->
                                    <input type="hidden" id="nilai_project" name="nilai_project"
                                        value="{{ $row->nilai_project }}">
                                </div>


                                <div class="col-6">
                                    <label class="form-label">Waktu Mulai Pelaksanaan</label>
                                    <input type="date" name="mulai_pelaksanaan" value="{{ $row->mulai_pelaksanaan }}"
                                        class="form-control">
                                </div>

                                <div class="col-6">
                                    <label class="form-label">Waktu Selesai Pelaksanaan</label>
                                    <input type="date" name="selesai_pelaksanaan"
                                        value="{{ $row->selesai_pelaksanaan }}" class="form-control">
                                </div>

                                <div class="col-6">
                                    <label class="form-label">Waktu Mulai Persiapan</label>
                                    <input type="date" name="mulai_persiapan" value="{{ $row->mulai_persiapan }}"
                                        class="form-control">
                                </div>

                                <div class="col-6">
                                    <label class="form-label">Waktu Selesai Persiapan</label>
                                    <input type="date" name="selesai_persiapan" value="{{ $row->selesai_persiapan }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Durasi Pelaksanaan</label>
                                    <input type="text" name="durasi_pelaksanaan"
                                        value="{{ $row->durasi_pelaksanaan }}" class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Durasi Persiapan</label>
                                    <input type="text" name="durasi_persiapan" value="{{ $row->durasi_persiapan }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Total Durasi</label>
                                    <input type="text" name="total_durasi" value="{{ $row->total_durasi }}"
                                        class="form-control">
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary">Update</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <script>
            function hitungDurasi() {
                const mulaiPel = document.getElementById('mulai_pelaksanaan').value;
                const selesaiPel = document.getElementById('selesai_pelaksanaan').value;
                const mulaiPer = document.getElementById('mulai_persiapan').value;
                const selesaiPer = document.getElementById('selesai_persiapan').value;

                let durasiPel = 0;
                let durasiPer = 0;

                // Hitung durasi pelaksanaan
                if (mulaiPel && selesaiPel) {
                    const start = new Date(mulaiPel);
                    const end = new Date(selesaiPel);
                    durasiPel = (end - start) / 1000 / 3600;
                    durasiPel = durasiPel > 0 ? durasiPel : 0;
                }

                // Hitung durasi persiapan
                if (mulaiPer && selesaiPer) {
                    const start = new Date(mulaiPer);
                    const end = new Date(selesaiPer);
                    durasiPer = (end - start) / 1000 / 3600;
                    durasiPer = durasiPer > 0 ? durasiPer : 0;
                }

                document.getElementById('durasi_pelaksanaan').value = Math.floor(durasiPel);
                document.getElementById('durasi_persiapan').value = Math.floor(durasiPer);
                document.getElementById('total_durasi').value = Math.floor(durasiPel + durasiPer);
            }

            document.querySelectorAll('#mulai_pelaksanaan, #selesai_pelaksanaan, #mulai_persiapan, #selesai_persiapan')
                .forEach(input => input.addEventListener('change', hitungDurasi));
        </script>
        <script>
            const viewInput = document.getElementById('nilai_project_view');
            const realInput = document.getElementById('nilai_project');

            viewInput.addEventListener('input', function() {
                // Hapus titik
                let angka = this.value.replace(/\./g, '');

                // Simpan ke hidden input (untuk submit)
                realInput.value = angka;

                // Format ulang tampilan pakai titik ribuan
                this.value = angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        </script>
        <script>
            const viewInput = document.getElementById('nilai_project_view');
            const realInput = document.getElementById('nilai_project');

            viewInput.addEventListener('input', function() {
                // Hilangkan semua titik
                let angka = this.value.replace(/\./g, '');

                // Simpan nilai asli ke hidden input
                realInput.value = angka;

                // Format tampilan (tambah titik setiap ribuan)
                this.value = angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        </script>
    @endforeach

@endsection
