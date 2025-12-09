<?php

namespace App\Http\Controllers;

use App\Models\grupkolom;
use App\Models\TarikModul;
use Illuminate\Http\Request;

class GrupKolomConntroller extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'nama_grup' => 'required',
            'jumlah' => 'required|integer',
            'waktu' => 'required|integer',
        ]);

        $nama = $request->nama_grup;
        $jumlah = $request->jumlah;
        $waktu = $request->waktu;

        // ===============================
        // 1. Generate TarikModul (tetap banyak)
        // ===============================
        for ($i = 1; $i <= $jumlah; $i++) {
            TarikModul::create([
                'modul' => $nama . " " . $i,
                'type_template' => "angka-hilang",
                'waktu' => $waktu,
            ]);
        }

        // ===============================
        // 2. Generate satu kolom isi grup_kolom
        // ===============================

        // Buat string panjang seperti: papikostik 1, papikostik 2, ..., papikostik 10
        $list = [];
        for ($i = 1; $i <= $jumlah; $i++) {
            $list[] = $nama . " " . $i;
        }

        // Gabungkan jadi 1 string
        $finalIsi = implode(", ", $list);

        grupkolom::create([
            'nama_grup' => $nama,
            'isi' => $finalIsi,
        ]);

        return redirect()->back()->with('success', 'Grup & modul berhasil digenerate!');
    }

    public function index()
    {
        $data = grupkolom::select('id', 'nama_grup')
            ->groupBy('nama_grup', 'id')
            ->get();

        return view('admin.angkahilang', compact('data'));
    }
    public function detail($nama)
    {
        // Ambil grup
        $grup = grupkolom::where('nama_grup', $nama)->first();

        // Pecah isi jadi array
        $items = explode(", ", $grup->isi);

        // Cari modul berdasarkan nama modul, bukan type_template
        $modul = TarikModul::whereIn('modul', $items)->get();

        return view('admin.datail-angkahilang', compact('nama', 'items', 'modul'));
    }
    public function update(Request $request, $id)
    {
        $modul = TarikModul::findOrFail($id);
        $oldName = $modul->modul;

        // Update modul
        $modul->update([
            'modul' => $request->modul,
            'waktu' => $request->waktu
        ]);

        // Update di tabel grup_kolom
        $grup = grupkolom::where('isi', 'LIKE', "%$oldName%")->first();

        if ($grup) {
            // pecah isi
            $items = explode(", ", $grup->isi);

            // ganti hanya yang cocok
            foreach ($items as &$item) {
                if ($item === $oldName) {
                    $item = $request->modul;
                }
            }

            // simpan lagi
            $grup->isi = implode(", ", $items);
            $grup->save();
        }

        return back()->with('success', 'Modul berhasil diupdate');
    }
    public function delete($id)
    {
        $modul = TarikModul::findOrFail($id);
        $name = $modul->modul;

        // HAPUS MODUL
        $modul->delete();

        // UPDATE GRUP KOLOM (hapus 1 item saja)
        $grup = grupkolom::where('isi', 'LIKE', "%$name%")->first();

        if ($grup) {
            $items = explode(", ", $grup->isi);

            // buang item
            $items = array_filter($items, function ($i) use ($name) {
                return trim($i) !== trim($name);
            });

            $grup->isi = implode(", ", $items);
            $grup->save();
        }

        return back()->with('success', 'Modul berhasil dihapus');
    }
    public function tambahKolom(Request $request)
    {
        $request->validate([
            'nama_grup' => 'required',
            'isi_baru' => 'required',
            'waktu' => 'required|integer',
        ]);

        $nama = $request->nama_grup;
        $isiBaru = $request->isi_baru;
        $waktu = $request->waktu;

        // 1. UPDATE grup_kolom
        $g = grupkolom::where('nama_grup', $nama)->first();

        // tambahkan isi baru
        $list = $g->isi . ", " . $isiBaru;

        $g->update([
            'isi' => $list
        ]);

        // 2. INSERT ke tarik_modul
        TarikModul::create([
            'modul' => $isiBaru,
            'type_template' => 'angka-hilang',
            'waktu' => $waktu
        ]);

        return redirect()->back()->with('success', 'Kolom baru berhasil ditambahkan!');
    }

    public function destroy($nama)
    {
        $grup = grupkolom::where('nama_grup', $nama)->first();

        if (!$grup) return back()->with('error', 'Data tidak ditemukan');

        // Ambil semua modul dari kolom isi → array
        $items = explode(", ", $grup->isi);

        // Hapus semua TarikModul yg modul ada di daftar
        TarikModul::whereIn('modul', $items)->delete();

        // Hapus grup kolom
        $grup->delete();

        return back()->with('success', 'Data dan modul terkait berhasil dihapus!');
    }
    public function updatek(Request $request, $id)
    {
        $request->validate([
            'nama_grup' => 'required',
        ]);

        $grup = grupkolom::find($id);

        // pecah modul lama
        $oldItems = explode(", ", $grup->isi);

        // generate modul baru
        $newItems = [];
        foreach ($oldItems as $i => $old) {
            $newItems[] = $request->nama_grup . " " . ($i + 1);

            // update juga ke TarikModul
            TarikModul::where('modul', $old)->update([
                'modul' => $request->nama_grup . " " . ($i + 1),
            ]);
        }

        // update grup & isi
        $grup->update([
            'nama_grup' => $request->nama_grup,
            'isi' => implode(", ", $newItems),
        ]);

        return back()->with('success', 'Nama grup dan modul berhasil diupdate!');
    }
}
