@extends('layouts.main-page')

@section('title', 'Dashboard')
@section('content4')
    <div class="card p-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <h3>Master Role & Shift</h3>

        <form action="{{ route('role.store') }}" method="POST">
            @csrf
            <input type="text" name="nama_role" class="form-control" placeholder="Nama Role" required>
            <button class="btn btn-primary mt-2">Tambah Role</button>
        </form>
    </div>

    <hr>
    @foreach ($roles as $role)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <h5>{{ $role->nama_role }}</h5>

                <form action="{{ route('role.delete', $role->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </div>

            <div class="card-body">

                <!-- LIST SHIFT -->
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Fee/Unit</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($role->shifts as $shift)
                            <tr>
                                <td>{{ $shift->jam_mulai }}</td>
                                <td>{{ $shift->jam_selesai }}</td>
                                <td>Rp {{ number_format($shift->fee_per_unit) }}</td>
                                <td>
                                    <form action="{{ route('shift.delete', $shift->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">X</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- FORM TAMBAH SHIFT -->
                <form action="{{ route('shift.store', $role->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <input type="time" name="jam_mulai" class="form-control" required>
                        </div>
                        <div class="col">
                            <input type="time" name="jam_selesai" class="form-control" required>
                        </div>
                        <div class="col">
                            <input type="number" name="fee_per_unit" class="form-control" placeholder="Fee per unit"
                                required>
                        </div>
                        <div class="col">
                            <button class="btn btn-success">Tambah Shift</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    @endforeach


@endsection
