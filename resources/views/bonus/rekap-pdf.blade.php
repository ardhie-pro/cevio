<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #222;
            padding: 6px;
        }

        th {
            background: #ddd;
        }

        h3 {
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <h3>Rekap Bonus</h3>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Bonus</th>
                <th>Bank</th>
                <th>Cabang</th>
                <th>No Rekening</th>
                <th>Nama NPWP</th>
                <th>NPWP</th>
                <th>Alamat NPWP</th>
                <th>NIK</th>
                <th>Alamat</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->bonus ?? '-' }}</td>
                    <td>{{ $row->bank ?? '-' }}</td>
                    <td>{{ $row->cabang ?? '-' }}</td>
                    <td>{{ $row->no_rek ?? '-' }}</td>
                    <td>{{ $row->nama_npwp ?? '-' }}</td>
                    <td>{{ $row->npwp ?? '-' }}</td>
                    <td>{{ $row->alamat_npwp ?? '-' }}</td>
                    <td>{{ $row->nik ?? '-' }}</td>
                    <td>{{ $row->alamat ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
