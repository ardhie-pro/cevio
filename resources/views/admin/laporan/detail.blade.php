<div class="container mt-4">
    <h4>Laporan Jawaban - <strong>Kode: {{ $kode }}</strong> | User: <strong>{{ $user_id }}</strong></h4>

    <table class="table table-bordered mt-3">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Modul</th>
                <th>Nomor Soal</th>
                <th>Jawaban User</th>
                <th>Jawaban Benar</th>
                <th>Status</th>
                <th>Poin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->modul }}</td>
                    <td>{{ $row->no }}</td>
                    <td>{{ $row->jawaban_user }}</td>
                    <td>{{ $row->jawaban_benar }}</td>
                    <td>
                        <span class="badge {{ $row->status == 'Benar' ? 'bg-success' : 'bg-danger' }}">
                            {{ $row->status }}
                        </span>
                    </td>
                    <td>{{ $row->poin }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="alert alert-success mt-3">
        <strong>Total Nilai:</strong> {{ $totalPoin }}
    </div>
</div>
