<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\grupkolom;
use Illuminate\Http\Request;
use App\Models\TarikModul;
use App\Models\SoalMultipleChoice;
use App\Models\SoalModul;

class TarikModulController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type'); // contoh: data-nama,istirahat

        $query = TarikModul::latest();

        if ($type) {
            // Ubah string jadi array
            $types = explode(',', $type);

            // Cari semua type dalam array
            $query->whereIn('type_template', $types);
        }

        $data = $query->get();

        return view('admin.tambah-modul', compact('data', 'type'));
    }



    public function store(Request $request)
    {
        TarikModul::create([
            'modul' => $request->modul,
            'type_template' => $request->type_template,
            'waktu' => $request->waktu,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $item = TarikModul::findOrFail($id);
        $item->update([
            'modul' => $request->modul,
            'type_template' => $request->type_template,
            'waktu' => $request->waktu,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Ambil data tarik modul
        $tarik = TarikModul::findOrFail($id);

        // Ambil modul & tipe
        $modul = $tarik->modul;
        $type = $tarik->type_template;


        // Hapus di tabel yang sesuai
        if ($type == 'angka-hilang') {

            // Hapus dari soal_modul
            SoalModul::where('modul', $modul)
                ->delete();
        } elseif ($type == 'multiple-chois' || $type == 'tanpa-kembali' || $type == 'panduan') {

            // Hapus dari multiple_chois
            SoalMultipleChoice::where('modul', $modul)->delete();
        }

        // Hapus data utama di tarik_modul
        $tarik->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
