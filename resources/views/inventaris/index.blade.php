@extends('layouts.main-page')
@section('title', 'Inventaris Vendor')


@section('content4')
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <h4>📦 Data Inventaris Vendor</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                + Tambah Vendor
            </button>
        </div>

        <div class="card p-5">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Vendor</th>
                        <th>PIC</th>
                        <th>No Telepon</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventaris as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->vendor }}</td>
                            <td>{{ $row->pic }}</td>
                            <td>{{ $row->no_telepon }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $row->id }}">Edit</button>
                                <form action="{{ route('inventaris.destroy', $row->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus data?')">Hapus</button>
                                </form>
                            </td>
                        </tr>


                        {{-- MODAL EDIT --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @foreach ($inventaris as $row)
        <div class="modal fade" id="modalEdit{{ $row->id }}">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('inventaris.update', $row->id) }}" class="modal-content">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5>Edit Inventaris</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="vendor" class="form-control mb-2" value="{{ $row->vendor }}" required>
                        <input type="text" name="pic" class="form-control mb-2" value="{{ $row->pic }}" required>
                        <input type="text" name="no_telepon" class="form-control" value="{{ $row->no_telepon }}">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('inventaris.store') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5>Tambah Inventaris</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="vendor" class="form-control mb-2" placeholder="Vendor" required>
                    <input type="text" name="pic" class="form-control mb-2" placeholder="PIC" required>
                    <input type="text" name="no_telepon" class="form-control" placeholder="No Telepon">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
