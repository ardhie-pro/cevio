@extends('layouts.main-page')

@section('title', 'Dashboard')

@section('content4')
    <div class="container">

        <h3>Kru Event: {{ $event->nama_event }}</h3>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKru">Tambah Kru</button>

        <hr>

        <div class="card">
            <div class="card-header bg-primary text-white">Daftar Kru</div>

            <div class="card-body p-0">
                @php
                    function durasi($mulai, $selesai)
                    {
                        $s = \Carbon\Carbon::parse($mulai);
                        $e = \Carbon\Carbon::parse($selesai);
                        return $e->diffInHours($s);
                    }
                @endphp

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kru</th>
                            <th>Role</th>
                            <th>Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Durasi</th>
                            <th>Fee / Unit</th>
                            <th>Total Fee</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->kru as $i => $k)
                            @php
                                $jam = durasi($k->roleShift->jam_mulai, $k->roleShift->jam_selesai);
                                $fee = $k->fee_per_unit ?? $k->roleShift->fee_per_unit;
                                $total = $fee; // FIX: tidak dikali durasi karena gaji fix per shift
                            @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $k->user->name }}</td>
                                <td>{{ $k->roleShift->role->nama_role }}</td>
                                <td>{{ $k->created_at->format('d M Y') }}</td>
                                <td>{{ $k->roleShift->jam_mulai }}</td>
                                <td>{{ $k->roleShift->jam_selesai }}</td>
                                <td>{{ $jam }} Jam</td>
                                <td>Rp {{ number_format($fee, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                                <td>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @php
                    $rekap = [];

                    foreach ($event->kru as $k) {
                        // Ambil fee
                        $fee = $k->fee_per_unit ?? $k->roleShift->fee_per_unit;

                        // Ambil jumlah unit (kalau ga ada, default 1)
                        $unit = $k->unit ?? 1;

                        // Total per row kru
                        $total = $fee * $unit;

                        // Simpan rekap berdasarkan user_id
                        if (!isset($rekap[$k->user_id])) {
                            $rekap[$k->user_id] = [
                                'nama' => $k->user->name,
                                'total' => 0,
                            ];
                        }

                        // Tambahkan total
                        $rekap[$k->user_id]['total'] += $total;
                    }
                @endphp

            </div>


        </div>
        <div class="card p-5">
            <h4>Total Gaji Per Kru</h4>

            <!-- Tombol Download -->
            <a href="{{ route('event.kru.rekap.invoice', $event->id) }}" class="btn btn-success mb-3">
                Download Rekap Gaji (PDF)
            </a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Kru</th>
                        <th>Total Gaji</th>
                        <th>Invoice</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekap as $userId => $r)
                        <tr>
                            <td>{{ $r['nama'] }}</td>
                            <td>Rp {{ number_format($r['total'], 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('event.kru.invoice.total', [$event->id, $userId]) }}"
                                    class="btn btn-primary btn-sm">
                                    Invoice
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ===================== MODAL TAMBAH KRU ====================== --}}
        <div class="modal fade" id="modalTambahKru">
            <div class="modal-dialog">
                <form action="{{ route('event.kru', $event->id) }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Tambah Kru</h5>
                        </div>

                        <div class="modal-body">

                            <label>Pilih Kru</label>
                            <select class="form-control" name="user_id" required>
                                <option value="">-- Pilih Kru --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>

                            <label>Pilih Role</label>
                            <select class="form-control" id="role_id">
                                <option value="">-- Pilih Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                                @endforeach
                            </select>

                            <label>Pilih Shift</label>
                            <select class="form-control" name="role_shift_id" id="shift_id">
                                <option value="">-- Pilih Shift --</option>
                            </select>

                            <label>Tanggal Kerja</label>
                            <input type="date" class="form-control" name="tanggal_kerja" required>

                            <label>Fee Per Unit</label>
                            <input type="text" class="form-control" id="fee" name="fee_per_unit" readonly>

                            <label>Jumlah Unit</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah_unit" value="1">

                            <label>Total Gaji</label>
                            <input type="text" class="form-control" id="total" name="total_gaji" readonly>

                            <label>Skor Performance (1-10)</label>
                            <input type="number" class="form-control" name="score_performance" min="1"
                                max="10">

                            <label>Catatan Performance</label>
                            <textarea class="form-control" name="catatan_performance"></textarea>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>


    </div>



@endsection
