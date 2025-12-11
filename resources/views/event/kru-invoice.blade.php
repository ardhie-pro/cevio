<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }

        /* TABLE BASE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            vertical-align: top;
        }

        /* ALIGNMENT */
        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        /* HEADER */
        .header {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: bold;
        }

        /* LEFT & RIGHT SECTIONS */
        .left,
        .right {
            vertical-align: top;
            padding: 10px;
            border: none;
        }

        /* TITLE LABEL */
        .label-title {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
            font-size: 16px;
        }

        /* EVENT HIGHLIGHT BOX */
        .event-box {

            padding: 6px;
            display: inline-block;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 2px;
            min-width: 260px;
            text-align: center;
            border: 1px solid #999;
        }

        /* ERROR YELLOW BOX */
        .error-box {
            background: yellow;
            padding: 5px 10px;
            margin-bottom: 8px;
            width: 100%;
            font-weight: bold;
            border: 1px solid #999;
        }

        /* SMALL TEXT */
        .small-text {
            font-size: 14px;
            margin-bottom: 4px;
        }

        /* LABEL ON RIGHT SIDE */
        .right-label {
            font-weight: bold;
            margin-bottom: 3px;
            display: block;
        }

        /* TABLE WITHOUT BORDER (SUMMARY) */
        .no-border td {
            border: none;
            padding: 4px 0;
        }

        td[width="5%"] {
            border: none !important;
        }
    </style>
</head>

<body>

    <h2 class="header">PERSONAL INVOICE PUBLISHER</h2>

    <table class="table">
        <tr>
            <!-- LEFT SIDE -->
            <td class="left" width="45%">
                <span class="label-title">Invoice to:</span>

                <div class="small-text">
                    PT. Karya Wilasa Nusantara
                </div>

                <div class="small-text">
                    <strong>
                        {{ $eventName }}
                    </strong>

                </div>

            </td>

            <!-- CENTER SPACER -->
            <td width="5%"></td>

            <!-- RIGHT SIDE -->
            <td class="right" width="50%">
                <div class="right-label">Paid to</div>
                <div class="error-box">#ERROR!</div>

                <div class="right-label">Nama Bank</div>
                <div class="error-box">#ERROR!</div>

                <div class="right-label">Cabang</div>
                <div class="error-box">#ERROR!</div>

                <div class="right-label">No Rekening</div>
                <div class="error-box">#ERROR!</div>

                <div class="right-label">an</div>
                <div class="error-box">#ERROR!</div>

                <div class="right-label">Nama NPWP</div>
                <div class="error-box">#ERROR!</div>

                <div class="right-label">No NPWP</div>
                <div class="error-box">#ERROR!</div>

                <div class="right-label">Alamat NPWP</div>
                <div class="error-box">#ERROR!</div>

                <div class="right-label">NIK</div>
                <div class="error-box">#ERROR!</div>

                <div class="right-label">Alamat</div>
                <div class="error-box">#ERROR!</div>
            </td>
        </tr>
    </table>


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
                    <td class="center">Rp{{ number_format($fee, 0, ',', '.') }}</td>
                    <td class="center">Rp{{ number_format($total, 0, ',', '.') }}</td>
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
