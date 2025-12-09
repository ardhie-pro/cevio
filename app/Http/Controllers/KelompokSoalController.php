<?php

namespace App\Http\Controllers;

use App\Models\KelompokSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelompokSoalController extends Controller
{
    // Menampilkan semua data
    public function index()
    {
        $data = KelompokSoal::all();
        return view('admin.index', compact('data'));
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'nullable|string',
            'persamaan' => 'nullable|string',
            'soal1_text' => 'nullable|string',
            'soal1_img' => 'nullable|image|max:2048',
            'soal2_text' => 'nullable|string',
            'soal2_img' => 'nullable|image|max:2048',
            'soal3_text' => 'nullable|string',
            'soal3_img' => 'nullable|image|max:2048',
            'soal4_text' => 'nullable|string',
            'soal4_img' => 'nullable|image|max:2048',
            'soal5_text' => 'nullable|string',
            'soal5_img' => 'nullable|image|max:2048',
        ]);

        // 🔥 Cek apakah judul sudah ada
        if (KelompokSoal::where('judul', $request->judul)->exists()) {
            return redirect()->back()
                ->with('error', 'Kolom sudah ada!')
                ->withInput();
        }

        // Simpan gambar jika ada
        for ($i = 1; $i <= 5; $i++) {
            if ($request->hasFile("soal{$i}_img")) {
                $data["soal{$i}_img"] = $request->file("soal{$i}_img")->store('soal_images', 'public');
            }
        }

        $soal = KelompokSoal::create($data);

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }


    public function edit($id)
    {
        $data = KelompokSoal::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $soal = KelompokSoal::findOrFail($id);

        $data = $request->validate([
            'judul' => 'nullable|string',
            'soal1_text' => 'nullable|string',
            'soal1_img' => 'nullable|image|max:2048',
            'soal2_text' => 'nullable|string',
            'soal2_img' => 'nullable|image|max:2048',
            'soal3_text' => 'nullable|string',
            'soal3_img' => 'nullable|image|max:2048',
            'soal4_text' => 'nullable|string',
            'soal4_img' => 'nullable|image|max:2048',
            'soal5_text' => 'nullable|string',
            'soal5_img' => 'nullable|image|max:2048',
        ]);

        // Ganti gambar lama jika upload baru
        for ($i = 1; $i <= 5; $i++) {
            if ($request->hasFile("soal{$i}_img")) {
                if ($soal["soal{$i}_img"]) {
                    \Storage::disk('public')->delete($soal["soal{$i}_img"]);
                }
                $data["soal{$i}_img"] = $request->file("soal{$i}_img")->store('soal_images', 'public');
            }
        }

        $soal->update($data);

        return redirect()
            ->route('kelompok-soal.index')
            ->with('success', 'Data berhasil diupdate!');
    }
    // Hapus data
    public function destroy($id)
    {
        $soal = KelompokSoal::findOrFail($id);

        // Hapus semua gambar terkait
        for ($i = 1; $i <= 5; $i++) {
            if ($soal["soal{$i}_img"]) {
                Storage::disk('public')->delete($soal["soal{$i}_img"]);
            }
        }

        $soal->delete();

        return redirect()
            ->route('kelompok-soal.index')
            ->with('success', 'Data berhasil dihapus!');
    }
}
