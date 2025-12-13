@extends('layouts.main-page') {{-- sesuaikan layout kamu --}}

@section('title', 'Dashboard')

@section('content4')
    <div class="container-fluid">

        <h4 class="mb-4">Dashboard Saya</h4>

        {{-- INFO USER --}}
        <div class="card mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">{{ auth()->user()->name }}</h6>
                    <small class="text-muted">
                        {{ ucfirst(auth()->user()->status) }}
                    </small>
                </div>
                <a href="{{ route('user.profile.edit') }}" class="btn btn-sm btn-outline-primary">
                    Edit Profil
                </a>
            </div>
        </div>

        {{-- HISTORY EVENT --}}
        <div class="card">
            <div class="card-header">
                <strong>History Event</strong>
            </div>

            <div class="card-body p-0">
                @if ($events->count())
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Event</th>
                                    <th>Tanggal</th>
                                    <th>Role</th>
                                    <th>Shift</th>
                                    <th>Total Gaji</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                    @php
                                        $kru = $event->kru->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $event->nama_event }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($kru->tanggal_kerja)->format('d M Y') }}
                                        </td>
                                        <td>{{ $kru->role->nama_role ?? '-' }}</td>
                                        <td>
                                            {{ $kru->roleShift->jam_mulai ?? '-' }}
                                            -
                                            {{ $kru->roleShift->jam_selesai ?? '-' }}
                                        </td>
                                        <td>
                                            Rp {{ number_format($kru->total_gaji) }}
                                        </td>
                                        <td>
                                            <a href="{{ route('user.event.show', $event->id) }}"
                                                class="btn btn-sm btn-primary">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-4 text-center text-muted">
                        Belum ada history event
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
