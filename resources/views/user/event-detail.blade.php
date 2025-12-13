<h4>{{ $event->nama_event }}</h4>

<ul class="list-group">
    <li class="list-group-item">
        <strong>Role:</strong> {{ $kru->role->nama_role }}
    </li>
    <li class="list-group-item">
        <strong>Shift:</strong>
        {{ $kru->roleShift->jam_mulai }} - {{ $kru->roleShift->jam_selesai }}
    </li>
    <li class="list-group-item">
        <strong>Total Gaji:</strong>
        Rp {{ number_format($kru->total_gaji) }}
    </li>
</ul>
