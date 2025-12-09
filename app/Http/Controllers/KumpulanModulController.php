<?php

namespace App\Http\Controllers;

use App\Models\KumpulanModul;
use App\Models\grupkolom;
use App\Models\TarikModul;
use Illuminate\Http\Request;

class KumpulanModulController extends Controller
{
    public function index()
    {
        $kumpulan = KumpulanModul::all();
        return view('admin.modul', compact('kumpulan'));
    }

    public function create()
    {
        $kAngkahilang = grupkolom::all();
        $modul = TarikModul::all(); // ambil semua modul yang bisa dicentang
        return view('admin.kumpulan-modul', compact('modul', 'kAngkahilang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'modul_ids' => 'nullable|array',
        ]);

        KumpulanModul::create($validated);

        return redirect()->route('kumpulan-modul.index')->with('success', 'Kumpulan modul berhasil dibuat!');
    }

    public function edit(KumpulanModul $kumpulanModul)
    {
        $modul = TarikModul::all();
        return view('admin.kumpulan-modul.edit', compact('kumpulanModul', 'modul'));
    }

    public function update(Request $request, KumpulanModul $kumpulanModul)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'modul_ids' => 'nullable|array',
        ]);

        $kumpulanModul->update($validated);

        return redirect()->route('kumpulan-modul.index')->with('success', 'Kumpulan modul berhasil diupdate!');
    }

    public function destroy(KumpulanModul $kumpulanModul)
    {
        $kumpulanModul->delete();
        return redirect()->route('kumpulan-modul.index')->with('success', 'Kumpulan modul berhasil dihapus!');
    }
}
