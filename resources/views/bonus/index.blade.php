@extends('layouts.main-page')

@section('title', 'Setting Bonus JPT')

@section('content4')
    <div class="container">

        <h3>Setting Bonus Untuk JPT</h3>

        <form method="GET" class="mb-3">
            <label>Pilih Tahun:</label>
            <select name="tahun" onchange="this.form.submit()">
                <option value="all" {{ $tahun == 'all' ? 'selected' : '' }}>All</option>

                @for ($i = 2023; $i <= date('Y'); $i++)
                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </form>

        <form action="{{ route('bonus.save') }}" method="POST">
            @csrf

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Daftar Event - Role - Performance</th>
                        <th>Bonus</th>
                        <th>Catatan</th>
                        <th>Di Update Oleh</th>

                    </tr>
                </thead>
                <tbody>

                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>

                            <td>
                                <ul>
                                    @foreach ($user->eventKru as $kru)
                                        @if ($tahun === 'all' || \Carbon\Carbon::parse($kru->tanggal_kerja)->year == $tahun)
                                            <li>
                                                {{ $kru->event->nama_event ?? '-' }} |
                                                {{ $kru->role->nama_role ?? '-' }} |
                                                Score: {{ $kru->score_performance ?? '-' }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </td>

                            <td>
                                <input type="number" name="bonus[{{ $user->id }}][bonus]" class="form-control"
                                    value="{{ $rekap[$user->id]->bonus ?? '' }}" placeholder="0">
                            </td>

                            <td>
                                <input type="text" name="bonus[{{ $user->id }}][catatan]" class="form-control"
                                    value="{{ $rekap[$user->id]->catatan ?? '' }}" placeholder="Catatan">
                            </td>
                            <td>
                                <p>{{ $rekap[$user->id]->updated_by ?? '' }}</p>
                                <p>{{ $rekap[$user->id]->updated_at ?? '' }}</p>

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            <button class="btn btn-primary">SAVE</button>
            <a href="{{ route('bonus.download', ['tahun' => $tahun]) }}" class="btn btn-success">
                Download Rekap
            </a>
        </form>
    </div>
@endsection
