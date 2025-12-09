<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\EventKru;
use App\Models\User;
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

    public function destroy(Event $event)
    {
        $event->delete();
        return back()->with('success', 'Data berhasil dihapus!');
    }
    public function show($id)
    {
        $event = Event::with(['pemasukan', 'pengeluaran', 'kru.user'])
            ->findOrFail($id);

        // Ambil user dengan status kru
        $users = User::where('status', 'user')->get();

        return view('event.detail', compact('event', 'users'));
    }

    public function tambahPemasukan(Request $request, $id)
    {
        Pemasukan::create([
            'event_id' => $id,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan
        ]);

        return back()->with('success', 'Pemasukan berhasil ditambahkan');
    }

    public function tambahPengeluaran(Request $request, $id)
    {
        Pengeluaran::create([
            'event_id' => $id,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan
        ]);

        return back()->with('success', 'Pengeluaran berhasil ditambahkan');
    }

    public function tambahKru(Request $request, $id)
    {
        EventKru::create([
            'event_id' => $id,
            'user_id' => $request->user_id
        ]);

        return back()->with('success', 'Kru berhasil ditambahkan');
    }
}
