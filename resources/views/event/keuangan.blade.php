@extends('layouts.main-page')

@section('title', 'Dashboard')

@section('content4')
    <div class="container">

        <h3 class="mb-3">Keuangan Event: {{ $event->nama_event }}</h3>

        <!-- ALERT SALDO -->
        @php
            $totalMasuk = $event->pemasukan->where('type', 'masuk')->sum('nominal');
            $totalKembali = $event->pemasukan->where('type', 'kembali')->sum('nominal');
            $totalPengeluaran = $event->pengeluaran->sum('jumlah');

            $saldo = $totalMasuk - $totalKembali - $totalPengeluaran;
        @endphp

        <div class="alert alert-info p-3">
            <h5 class="m-0">
                <b>Saldo Akhir:
                    @if ($saldo >= 0)
                        <span class="text-success">Rp {{ number_format($saldo) }}</span>
                    @else
                        <span class="text-danger">Rp {{ number_format($saldo) }}</span>
                    @endif
                </b>
            </h5>
        </div>

        <button class="btn btn-success mb-5" data-bs-toggle="modal" data-bs-target="#modalPemasukan">Tambah Pettycash</button>
        <button class="btn btn-danger mb-5" data-bs-toggle="modal" data-bs-target="#modalPengeluaran">Tambah
            Pengeluaran</button>

        <!-- ===================== CARD PEMASUKAN ====================== -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white fw-bold">Pemasukan</div>
            <div class="card-body p-0">
                <table class="table table-striped m-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nominal</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                            <th>Bukti</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($event->pemasukan as $i => $p)
                            <tr>
                                <td>{{ $i + 1 }}</td>

                                <!-- Nominal -->
                                <td>
                                    @if ($p->type == 'masuk')
                                        <span class="text-success fw-bold">+ Rp {{ number_format($p->nominal) }}</span>
                                    @else
                                        <span class="text-danger fw-bold">- Rp {{ number_format($p->nominal) }}</span>
                                    @endif
                                </td>

                                <!-- Jenis -->
                                <td>
                                    @if ($p->type == 'masuk')
                                        <span class="badge bg-success">Uang Masuk</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Uang Kembali</span>
                                    @endif
                                </td>

                                <td>{{ $p->keterangan ?? '-' }}</td>
                                <td>{{ $p->created_at->format('d M Y') }}</td>

                                <!-- Bukti -->
                                <td>
                                    @if ($p->bukti_tf)
                                        <a href="{{ asset('storage/' . $p->bukti_tf) }}" target="_blank">
                                            <i class="bi bi-image"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <!-- ===================== CARD PENGELUARAN ====================== -->
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white fw-bold">Pengeluaran</div>
            <div class="card-body p-0">
                <table class="table table-striped m-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Item</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Invoice</th>
                            <th>Bukti</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($event->pengeluaran as $i => $p)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $p->tanggal_pembayaran ? \Carbon\Carbon::parse($p->tanggal_pembayaran)->format('d M Y') : '-' }}
                                </td>
                                <td>{{ $p->kategori ?? '-' }}</td>
                                <td>{{ $p->item ?? '-' }}</td>
                                <td>Rp {{ number_format($p->jumlah) }}</td>
                                <td><span class="badge bg-info">{{ $p->payment_status }}</span></td>

                                <td>
                                    @if ($p->invoice)
                                        <a href="{{ $p->invoice }}" target="_blank">Lihat</a>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    @if ($p->bukti_tf)
                                        <a href="{{ $p->bukti_tf }}" target="_blank">Bukti</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>


        {{-- CATEGORY DATA --}}
        @php
            $kategoriList = collect([
                (object) ['nama' => 'Transportasi'],
                (object) ['nama' => 'Dekorasi'],
                (object) ['nama' => 'Perlengkapan'],
                (object) ['nama' => 'Konsumsi'],
                (object) ['nama' => 'Vendor'],
                (object) ['nama' => 'Venue'],
                (object) ['nama' => 'Keamanan'],
                (object) ['nama' => 'Entertainment'],
                (object) ['nama' => 'Lainnya'],
            ]);
        @endphp

        {{-- MODAL PEMASUKAN --}}
        <div class="modal fade" id="modalPemasukan">
            <div class="modal-dialog">
                <form action="{{ route('event.pemasukan', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title">Tambah Pettycash</h5>
                        </div>

                        <div class="modal-body">

                            <label>Type</label>
                            <select class="form-control" name="type" id="typePemasukan" required>
                                <option value="masuk">Uang Masuk</option>
                                <option value="kembali">Uang Kembali</option>
                            </select>

                            <label class="mt-2">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" required>

                            <label class="mt-2">Metode</label>
                            <input type="text" class="form-control" name="metode" placeholder="Cash/Transfer" required>

                            <label class="mt-2">Nama Pengirim</label>
                            <input type="text" class="form-control" name="nama_pengirim">

                            <label class="mt-2">Jumlah</label>
                            <input type="number" class="form-control" name="nominal" required>

                            <label class="mt-3">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3"></textarea>

                            <div id="formKembali" style="display:none">
                                <label class="mt-3">Bukti Transfer</label>
                                <input type="file" class="form-control" name="bukti_tf">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        {{-- MODAL PENGELUARAN --}}
        <div class="modal fade" id="modalPengeluaran">
            <div class="modal-dialog">
                <form action="{{ route('event.pengeluaran', $event->id) }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Tambah Pengeluaran</h5>
                        </div>

                        <div class="modal-body">
                            <label>Tanggal Pembayaran</label>
                            <input type="date" name="tanggal_pembayaran" class="form-control">

                            <label class="mt-2">Kategori</label>
                            <select name="kategori" class="form-control">
                                @foreach ($kategoriList as $k)
                                    <option value="{{ $k->nama }}">{{ $k->nama }}</option>
                                @endforeach
                            </select>

                            <label class="mt-2">Item</label>
                            <input type="text" name="item" class="form-control">

                            <label class="mt-2">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control"></textarea>

                            <label class="mt-2">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control">

                            <label class="mt-2">Payment Method</label>
                            <select name="payment_method" class="form-control">
                                <option value="">-- Pilih Payment Method --</option>
                                <option value="Cash">Cash</option>
                                <option value="Transfer">Transfer</option>
                                <option value="Cek/Giro">Cek/Giro</option>
                            </select>


                            <label class="mt-2">PIC</label>
                            <input type="text" name="pic" class="form-control">

                            <label class="mt-2">Vendor</label>
                            <input type="text" name="vendor" class="form-control">

                            <label class="mt-2">Link Invoice / Nota</label>
                            <input type="text" name="invoice" class="form-control">

                            <label class="mt-2">Link Bukti Transfer</label>
                            <input type="text" name="bukti_tf" class="form-control">

                            <label class="mt-2">Payment Status</label>
                            <select name="payment_status" class="form-control">
                                <option>DP 1</option>
                                <option>DP 2</option>
                                <option>DP 3</option>
                                <option>DP 4</option>
                                <option>DP 5</option>
                                <option>LUNAS</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">Simpan</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        // Show/hide bukti tf saat type = kembali
        document.getElementById('typePemasukan').addEventListener('change', function() {
            document.getElementById('formKembali').style.display = (this.value === 'kembali') ? 'block' : 'none';
        });
    </script>

@endsection
