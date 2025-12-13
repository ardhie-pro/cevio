@extends('layouts.main-page')

@section('title', 'Edit Profil')

@section('content4')
    <div class="container-fluid">

        <h4 class="mb-4">Edit Profil</h4>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- DATA AKUN --}}
            <div class="card mb-4">
                <div class="card-header"><strong>Data Akun</strong></div>
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- DATA BANK --}}
            <div class="card mb-4">
                <div class="card-header"><strong>Data Bank</strong></div>
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">Nama Bank</label>
                        <input type="text" name="bank" class="form-control" value="{{ old('bank', $user->bank) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cabang Bank</label>
                        <input type="text" name="cabang" class="form-control"
                            value="{{ old('cabang', $user->cabang) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Rekening</label>
                        <input type="text" name="no_rek" class="form-control"
                            value="{{ old('no_rek', $user->no_rek) }}">
                    </div>

                </div>
            </div>

            {{-- DATA PAJAK --}}
            <div class="card mb-4">
                <div class="card-header"><strong>Data Pajak</strong></div>
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" class="form-control" value="{{ old('nik', $user->nik) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama NPWP</label>
                        <input type="text" name="nama_npwp" class="form-control"
                            value="{{ old('nama_npwp', $user->nama_npwp) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NPWP</label>
                        <input type="text" name="npwp" class="form-control" value="{{ old('npwp', $user->npwp) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat NPWP</label>
                        <textarea name="alamat_npwp" class="form-control" rows="2">{{ old('alamat_npwp', $user->alamat_npwp) }}</textarea>
                    </div>

                </div>
            </div>

            {{-- ALAMAT --}}
            <div class="card mb-4">
                <div class="card-header"><strong>Alamat Domisili</strong></div>
                <div class="card-body">

                    <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $user->alamat) }}</textarea>

                </div>
            </div>

            {{-- PASSWORD --}}
            <div class="card mb-4">
                <div class="card-header"><strong>Ubah Password</strong></div>
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengubah password
                    </small>

                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan Perubahan
            </button>

        </form>

    </div>
@endsection
