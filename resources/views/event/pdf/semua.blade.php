<h2>{{ $event->nama_event }}</h2>
<p><b>Lokasi:</b> {{ $event->lokasi }}</p>
<p><b>Client:</b> {{ $event->client }}</p>
<hr>

<h3>Data Kru</h3>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr>
        <th>Nama</th>
        <th>Role</th>
        <th>Shift</th>
        <th>Fee</th>
        <th>Total</th>
    </tr>

    @foreach ($event->kru as $k)
        <tr>
            <td>{{ $k->user->name }}</td>
            <td>{{ $k->role->nama_role }}</td>
            <td>{{ $k->roleShift->jam_mulai }} - {{ $k->roleShift->jam_selesai }}</td>
            <td>{{ number_format($k->fee_per_unit) }}</td>
            <td>{{ number_format($k->total_gaji) }}</td>
        </tr>
    @endforeach
</table>

<hr>

<h3>Pemasukan</h3>
<ul>
    @foreach ($event->pemasukan as $p)
        <li>{{ $p->keterangan }} - Rp {{ number_format($p->jumlah) }}</li>
    @endforeach
</ul>

<h3>Pengeluaran</h3>
<ul>
    @foreach ($event->pengeluaran as $p)
        <li>{{ $p->keterangan }} - Rp {{ number_format($p->jumlah) }}</li>
    @endforeach
</ul>
