<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .no-border td {
            border: none;
            padding: 4px 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <h2 class="header">Invoice Pembayaran Kru</h2>

    <p><strong>Nama Kru:</strong> {{ $user->name }}</p>

    <table>
        <thead>
            <tr class="center">
                <th>No</th>
                <th>Tanggal</th>
                <th>Role</th>
                <th>Unit</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($kruList as $i => $k)
                @php
                    $unit = $k->unit ?? 1;
                    $fee = $k->fee_per_unit ?? $k->roleShift->fee_per_unit;
                    $total = $unit * $fee;
                @endphp
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td class="center">{{ $k->created_at->format('d M Y') }}</td>
                    <td>{{ $k->roleShift->role->nama_role }}</td>
                    <td class="center">{{ $unit }}</td>
                    <td class="right">Rp{{ number_format($fee, 0, ',', '.') }}</td>
                    <td class="right">Rp{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>

    <table class="no-border">
        <tr>
            <td><strong>Total Gross</strong></td>
            <td class="right"><strong>Rp{{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td>Potong Pajak (2.5%)</td>
            <td class="right">Rp{{ number_format($pajak, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Transfer</strong></td>
            <td class="right"><strong>Rp{{ number_format($transfer, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <br><br><br>

    <p>Surabaya, {{ date('d F Y') }}</p>

    <p><strong>Tanda Tangan</strong></p>
    <img src="{{ public_path('tanda-tangan.png') }}" width="150">

</body>

</html>
