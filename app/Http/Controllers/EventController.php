<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\EventKru;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleShift;
use PDF;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $data = Event::latest()->get();
        return view('admin.dashboard', compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_manager' => 'required',
            'client' => 'required',
            'nama_event' => 'required',
            'lokasi' => 'required',
            'nilai_project' => 'nullable',

            'mulai_pelaksanaan' => 'nullable|date',
            'selesai_pelaksanaan' => 'nullable|date',
            'mulai_persiapan' => 'nullable|date',
            'selesai_persiapan' => 'nullable|date',

            'durasi_pelaksanaan' => 'nullable|integer',
            'durasi_persiapan' => 'nullable|integer',
            'total_durasi' => 'nullable|integer',
        ]);

        Event::create($data);

        return back()->with('success', 'Data berhasil disimpan!');
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'project_manager' => 'required',
            'client' => 'required',
            'nama_event' => 'required',
            'lokasi' => 'required',
            'nilai_project' => 'nullable',

            'mulai_pelaksanaan' => 'nullable|date',
            'selesai_pelaksanaan' => 'nullable|date',
            'mulai_persiapan' => 'nullable|date',
            'selesai_persiapan' => 'nullable|date',

            'durasi_pelaksanaan' => 'nullable|integer',
            'durasi_persiapan' => 'nullable|integer',
            'total_durasi' => 'nullable|integer',
        ]);

        $event->update($data);

        return back()->with('success', 'Data berhasil diperbarui!');
    }

    public function updateStatus(Request $request, Event $event)
    {
        $request->validate([
            'status' => 'required|in:Pending,Berjalan,Close'
        ]);

        $event->status = $request->status;
        $event->save();

        return response()->json(['success' => true]);
    }


    public function destroy(Event $event)
    {
        $event->delete();
        return back()->with('success', 'Data berhasil dihapus!');
    }
    public function show($id)
    {
        $event = Event::findOrFail($id);

        return view('event.show', compact('event'));
    }
    public function keuangan($id)
    {
        $event = Event::with(['pemasukan', 'pengeluaran'])->findOrFail($id);
        return view('event.keuangan', compact('event'));
    }
    public function kru($id)
    {
        $event = Event::with([
            'kru.user',
            'kru.roleShift',
            'kru.roleShift.role'
        ])->findOrFail($id);

        $users = User::where('status', 'user')->get();
        $roles = Role::with('shifts')->get();

        return view('event.kru', compact('event', 'users', 'roles'));
    }


    public function getShifts($id)
    {
        // Ambil shift berdasarkan role_id
        $shifts = RoleShift::where('role_id', $id)->get();

        return response()->json($shifts);
    }


    public function tambahPemasukan(Request $request, $id)
    {
        $data = $request->validate([
            'type' => 'required|in:masuk,kembali',
            'tanggal' => 'required|date',
            'metode' => 'required',
            'nama_pengirim' => 'nullable|string',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable',
            'bukti_tf' => 'nullable|file|mimes:jpg,png,pdf',
        ]);

        $data['event_id'] = $id;

        // upload bukti tf jika ada
        if ($request->hasFile('bukti_tf')) {
            $data['bukti_tf'] = $request->file('bukti_tf')->store('bukti_tf', 'public');
        }

        // jika uang kembali -> approval pending
        if ($request->type == 'kembali') {
            $data['approval'] = 'pending';
        }

        Pemasukan::create($data);

        return back()->with('success', 'Pemasukan berhasil ditambahkan');
    }


    public function tambahPengeluaran(Request $request, $id)
    {
        $data = $request->validate([
            'tanggal_pembayaran' => 'required|date',
            'kategori' => 'required',
            'item' => 'required',
            'deskripsi' => 'nullable',
            'jumlah' => 'required|numeric',
            'payment_method' => 'nullable',
            'pic' => 'nullable',
            'vendor' => 'nullable',
            'invoice' => 'nullable',
            'bukti_tf' => 'nullable',
            'payment_status' => 'required',
        ]);

        $data['event_id'] = $id;

        Pengeluaran::create($data);

        return back()->with('success', 'Pengeluaran berhasil ditambahkan');
    }


    // public function tambahKru(Request $request, $id)
    // {
    //     EventKru::create([
    //         'event_id' => $id,
    //         'user_id' => $request->user_id
    //     ]);

    //     return back()->with('success', 'Kru berhasil ditambahkan');
    // }

    public function tambahKru(Request $request, $id)
    {
        $shift = RoleShift::find($request->role_shift_id);

        EventKru::create([
            'event_id'        => $id,
            'user_id'         => $request->user_id,
            'tanggal_kerja'   => $request->tanggal_kerja,
            'role_id'         => $shift->role_id,
            'role_shift_id'   => $shift->id,

            'fee_per_unit'    => $shift->fee_per_unit,
            'jumlah_unit'     => $request->jumlah_unit,
            'total_gaji'      => $shift->fee_per_unit * $request->jumlah_unit,

            'score_performance'     => $request->score_performance,
            'catatan_performance'   => $request->catatan_performance
        ]);

        return back()->with('success', 'Kru berhasil ditambahkan');
    }


    public function invoiceTotal($event_id, $user_id)
    {
        $kruList = EventKru::with(['user', 'roleShift.role', 'event'])
            ->where('event_id', $event_id)
            ->where('user_id', $user_id)
            ->get();

        if ($kruList->isEmpty()) {
            abort(404, "Data kru tidak ditemukan");
        }

        $user = $kruList->first()->user;
        $eventName = $kruList->first()->event->nama_event; // <-- Tambah ini

        // Hitung total
        $grandTotal = 0;
        foreach ($kruList as $k) {
            $unit  = $k->unit ?? 1;
            $fee   = $k->fee_per_unit ?? $k->roleShift->fee_per_unit;
            $total = $unit * $fee;
            $grandTotal += $total;
        }

        $pajak    = $grandTotal * 0.025;
        $transfer = $grandTotal - $pajak;

        return PDF::loadView('event.kru-invoice', [
            'kruList'    => $kruList,
            'user'       => $user,
            'eventName'  => $eventName,  // <-- Kirim ke view
            'grandTotal' => $grandTotal,
            'pajak'      => $pajak,
            'transfer'   => $transfer
        ])
            ->setPaper('A4', 'portrait')
            ->stream("Invoice-Total-{$user->name}.pdf");
    }

    // public function pdfSemua($id)
    // {
    //     $event = Event::with(['pemasukan', 'pengeluaran', 'kru.user', 'kru.role', 'kru.roleShift'])
    //         ->findOrFail($id);

    //     $pdf = PDF::loadView('event.pdf.semua', compact('event'))
    //         ->setPaper('a4', 'portrait');

    //     return $pdf->download('laporan-event-' . $event->nama_event . '.pdf');
    // }

    public function pdfSemua($id)
    {
        $event = Event::with(['pemasukan', 'pengeluaran', 'kru.user', 'kru.role', 'kru.roleShift'])
            ->findOrFail($id);

        $pdf = PDF::loadView('event.pdf.semua', compact('event'))
            ->setPaper('a4', 'portrait');

        // Tampilkan preview PDF di browser (tidak mendownload)
        return $pdf->stream('laporan-event-' . $event->nama_event . '.pdf');
    }
    public function rekapInvoice($event_id)
    {
        $event = Event::findOrFail($event_id);

        // Ambil semua kru + relasi
        $kruList = EventKru::with(['user', 'roleShift.role'])
            ->where('event_id', $event_id)
            ->get();

        // Siapkan data rekap
        $rekap = [];

        foreach ($kruList as $k) {
            $uid = $k->user_id;

            $unit  = $k->unit ?? 1;
            $fee   = $k->fee_per_unit ?? $k->roleShift->fee_per_unit;
            $total = $unit * $fee;

            if (!isset($rekap[$uid])) {
                $rekap[$uid] = [
                    'nama' => $k->user->name ?? '-',
                    'nik'  => $k->user->nik ?? '-',
                    'npwp' => $k->user->npwp ?? '-',
                    'alamat' => $k->user->alamat ?? '-',
                    'bank' => $k->user->bank ?? '-',
                    'rekening' => $k->user->rekening ?? '-',
                    'total' => 0,
                ];
            }

            $rekap[$uid]['total'] += $total;
        }

        return PDF::loadView('event.rekap-gaji-pdf', [
            'rekap' => $rekap,
            'event' => $event
        ])
            ->setPaper('A4', 'landscape')
            ->stream("Rekap-Gaji-{$event->nama_event}.pdf");
    }
    public function detail($id)
    {
        $user = User::findOrFail($id);

        // Ambil seluruh riwayat kerja user
        $kru = EventKru::with(['event', 'role', 'roleShift'])
            ->where('user_id', $id)
            ->orderBy('tanggal_kerja', 'asc')
            ->get();

        // Identitas
        $pertamaKerja = $kru->first()->tanggal_kerja ?? '-';
        $terakhirKerja = $kru->last()->tanggal_kerja ?? '-';
        $jumlahEvent = $kru->count();
        $totalGaji = $kru->sum('total_gaji');
        $averagePerformance = $kru->avg('score_performance') ?? 0;


        return view('user.detail', compact(
            'user',
            'kru',
            'pertamaKerja',
            'terakhirKerja',
            'jumlahEvent',
            'totalGaji',
            'averagePerformance'
        ));
    }
    public function managerDetail($id)
    {
        $user = User::findOrFail($id);

        // Ambil semua event yang dia pegang
        $events = Event::with([
            'kru.user',
            'pemasukan',
            'pengeluaran'
        ])->where('project_manager', $user->name)->get();

        return view('admin.manajer-detail', compact('user', 'events'));
    }
}
