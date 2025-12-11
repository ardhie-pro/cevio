<!DOCTYPE html>
<html>

<head>
    <title>Rekap Gaji Kru</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }
    </style>
</head>

<body>

    <h2>Rekap Gaji Kru</h2>
    <p><strong>Event:</strong> {{ $event->nama_event ?? '-' }}</p>
    <p><strong>Tanggal:</strong> {{ now()->format('d F Y') }}</p>


    <table>
        <thead>
            <tr>
                <th>NAMA</th>
                <th>NIK</th>
                <th>NPWP</th>
                <th>ALAMAT</th>
                <th>BANK</th>
                <th>No Rekening</th>
                <th>TOTAL TRANSFER</th>
                <th>TAX (2.5%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekap as $r)
                @php
                    $pajak = $r['total'] * 0.025;
                    $transfer = $r['total'] - $pajak;
                @endphp
                <tr>
                    <td>{{ $r['nama'] }}</td>
                    <td>{{ $r['nik'] }}</td>
                    <td>{{ $r['npwp'] }}</td>
                    <td>{{ $r['alamat'] }}</td>
                    <td>{{ $r['bank'] }}</td>
                    <td>{{ $r['rekening'] }}</td>
                    <td>Rp {{ number_format($transfer, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($pajak, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
