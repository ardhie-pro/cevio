@extends('layouts.main-page')

@section('title', 'Detail User')

@section('content4')

    <div class="card p-5">


        <h3>Detail Kru: {{ $user->name }}</h3>
        <hr>

        <h5>Identitas</h5>
        <table class="table table-bordered">
            <tr>
                <th>Nama</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $user->status }}</td>
            </tr>
            <tr>
                <th>Pertama Kali Kerja</th>
                <td>{{ $pertamaKerja }}</td>
            </tr>
            <tr>
                <th>Terakhir Kali Kerja</th>
                <td>{{ $terakhirKerja }}</td>
            </tr>
            <tr>
                <th>Jumlah Project</th>
                <td>{{ $jumlahEvent }}</td>
            </tr>
            <tr>
                <th>Total Gaji</th>
                <td>Rp {{ number_format($totalGaji) }}</td>
            </tr>
            <tr>
                <th>Average Skor Performance</th>
                <td>{{ number_format($averagePerformance, 2) }}</td>
            </tr>
        </table>

        <hr>

        <h5>Riwayat Project</h5>

        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Client</th>
                    <th>Peran</th>
                    <th>Posisi (Shift)</th>
                    <th>Tgl Pelaksanaan</th>
                    <th>Tgl Persiapan</th>
                    <th>Total Gaji</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kru as $item)
                    <tr>
                        <td>{{ $item->event->nama_event }}</td>
                        <td>{{ $item->event->client }}</td>
                        <td>{{ $item->role->nama_role ?? '-' }}</td>
                        <td>
                            {{ $item->roleShift->jam_mulai ?? '-' }} -
                            {{ $item->roleShift->jam_selesai ?? '-' }}
                        </td>
                        <td>
                            {{ $item->event->mulai_pelaksanaan }} -
                            {{ $item->event->selesai_pelaksanaan }}
                        </td>
                        <td>
                            {{ $item->event->mulai_persiapan }} -
                            {{ $item->event->selesai_persiapan }}
                        </td>
                        <td>Rp {{ number_format($item->total_gaji) }}</td>
                        <td>{{ $item->score_performance }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
