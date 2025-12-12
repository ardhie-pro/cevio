@extends('layouts.main-page')

@section('title', 'Project Manager Detail')

@section('content4')
    <div class="card p-4">
        <h3>Detail Project Manager: <strong>{{ $user->name }}</strong></h3>
    </div>

    @foreach ($events as $event)
        <div class="card mt-4 p-4">
            <h4>{{ $event->nama_event }}</h4>
            <p><strong>Lokasi:</strong> {{ $event->lokasi }}</p>

            <hr>

            {{-- Total Gaji Kru --}}
            @php
                $totalGaji = $event->kru->sum('total_gaji');
                $totalPemasukan = $event->pemasukan->sum('nominal');
                $totalPengeluaran = $event->pengeluaran->sum('jumlah');
                $keuntungan = $totalPemasukan - $totalPengeluaran;
            @endphp

            <p><strong>Total Gaji Kru:</strong> Rp {{ number_format($totalGaji, 0, ',', '.') }}</p>
            <p><strong>Total Pemasukan:</strong> Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
            <p><strong>Total Pengeluaran:</strong> Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>

            <p>
                <strong>Hasil:</strong>
                @if ($keuntungan >= 0)
                    <span class="text-success">+ Rp {{ number_format($keuntungan, 0, ',', '.') }}</span>
                @else
                    <span class="text-danger">- Rp {{ number_format(abs($keuntungan), 0, ',', '.') }}</span>
                @endif
            </p>

            <hr>

            {{-- Kru --}}
            <h5>Kru yang Terlibat:</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Total Gaji</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($event->kru as $k)
                        <tr>
                            <td>{{ $k->user->name }}</td>

                            <td>Rp {{ number_format($k->total_gaji, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    @endforeach

@endsection
