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
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $row->nama_event }}</td>
                            <td>{{ $row->client }}</td>
                            <td>{{ $row->mulai_pelaksanaan }}</td>
                            <td>{{ $row->status }}</td>
                            {{-- <td>{{ $row->formatJam($row->durasi_pelaksanaan) }}</td>
                            <td>{{ $row->formatJam($row->durasi_persiapan) }}</td>
                            <td>{{ $row->formatJam($row->total_durasi) }}</td> --}}
                            <td>
                                <a href="{{ route('event.show', $row->id) }}" class="btn btn-sm btn-info">
                                    Detail
                                </a>

                                {{-- Jika bukan manajer, tampilkan Edit & Hapus --}}
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

                            <div class="col-md-6">
                                <label class="form-label">Project Manager</label>
                                <select name="project_manager" class="form-select" required>
                                    <option value="">Pilih...</option>
                                    <option>ardhie</option>
                                    <option>Michael</option>
                                    <option>Sandra</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Client</label>
                                <input type="text" name="client" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Event</label>
                                <input type="text" name="nama_event" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Lokasi</label>
                                <input type="text" name="lokasi" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nilai Project</label>
                                <input type="number" name="nilai_project" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Waktu Mulai Pelaksanaan</label>
                                <input type="date" name="mulai_pelaksanaan" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Waktu Selesai Pelaksanaan</label>
                                <input type="date" name="selesai_pelaksanaan" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Waktu Mulai Persiapan</label>
                                <input type="date" name="mulai_persiapan" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Waktu Selesai Persiapan</label>
                                <input type="date" name="selesai_persiapan" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Durasi Pelaksanaan</label>
                                <input type="text" name="durasi_pelaksanaan" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Durasi Persiapan</label>
                                <input type="text" name="durasi_persiapan" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Total Durasi</label>
                                <input type="text" name="total_durasi" class="form-control">
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

                                <div class="col-md-6">
                                    <label class="form-label">Project Manager</label>
                                    <select name="project_manager" class="form-select">
                                        <option {{ $row->project_manager == 'ardhie' ? 'selected' : '' }}>ardhie
                                        </option>
                                        <option {{ $row->project_manager == 'Michael' ? 'selected' : '' }}>Michael
                                        </option>
                                        <option {{ $row->project_manager == 'Sandra' ? 'selected' : '' }}>Sandra
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Client</label>
                                    <input type="text" name="client" value="{{ $row->client }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Nama Event</label>
                                    <input type="text" name="nama_event" value="{{ $row->nama_event }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" name="lokasi" value="{{ $row->lokasi }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Nilai Project</label>
                                    <input type="number" name="nilai_project" value="{{ $row->nilai_project }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Waktu Mulai Pelaksanaan</label>
                                    <input type="date" name="mulai_pelaksanaan" value="{{ $row->mulai_pelaksanaan }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Waktu Selesai Pelaksanaan</label>
                                    <input type="date" name="selesai_pelaksanaan"
                                        value="{{ $row->selesai_pelaksanaan }}" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Waktu Mulai Persiapan</label>
                                    <input type="date" name="mulai_persiapan" value="{{ $row->mulai_persiapan }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-6">
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
    @endforeach

@endsection
