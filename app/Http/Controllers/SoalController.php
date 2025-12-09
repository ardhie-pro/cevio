<?php

namespace App\Http\Controllers;

use DOMDocument;
use App\Models\KunciJawaban;
use App\Models\SoalMultipleChoice;
use App\Models\KelompokSoal;
use App\Models\SoalModul;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    public function importPreview(Request $request)
    {
        // Ambil isi CKEditor
        $html = $request->import_soal;

        // Misal parsing sederhana dulu
        return response()->json([
            'status' => 1,
            'soal' => $html
        ]);
    }

    public function importSave(Request $request)
    {
        // Simpan data soal ke DB
        return response()->json([
            'status' => 1
        ]);
    }

    public function index(Request $request)
    {
        $modul = $request->query('modul');
        $type_template = $request->query('type_template');

        if (!$modul) {
            return redirect()->back()->with('error', 'Modul tidak ditemukan.');
        }

        if (!$type_template) {
            return redirect()->back()->with('error', 'Type template tidak ditemukan.');
        }

        $data2 = SoalMultipleChoice::where('modul', $modul)
            ->orderByRaw('CAST(no AS UNSIGNED) ASC')
            ->get();
        $data = SoalModul::where('modul', $modul)->orderBy('no')->get();
        foreach ($data as $item) {
            $item->kelompok_data = KelompokSoal::where('judul', $item->kelompok)->first();
        }
        $kelompok = KelompokSoal::all(); // ambil data untuk select dropdown
        $galeri = DB::table('img_soal_random')->orderByDesc('id')->get();

        if ($type_template === 'angka-hilang') {
            return view('admin.tambah-soal', compact('data', 'modul', 'kelompok', 'type_template'));
        } elseif ($type_template === 'multiple-chois') {
            return view('admin.tambah_soal_multyple', compact('data2', 'modul', 'kelompok', 'galeri', 'type_template'));
        } elseif ($type_template === 'panduan') {
            return view('admin.panduan', compact('data2', 'modul', 'kelompok', 'galeri', 'type_template'));
        } elseif ($type_template === 'tanpa-kembali') {
            return view('admin.tambah_soal_multyple', compact('data2', 'modul', 'kelompok', 'galeri', 'type_template'));
        } else {
            return redirect()->back()->with('error', 'Type template tidak valid.');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no' => 'required',
            'modul' => 'required',
            'kelompok' => 'required',
            'soal2' => 'nullable',
            'j1' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'j2' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'j3' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'j4' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'j5' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $data = $validated;

        // upload gambar opsional
        foreach (['j1', 'j2', 'j3', 'j4', 'j5'] as $col) {
            if ($request->hasFile($col)) {
                $path = $request->file($col)->store('soal_images', 'public');
                $data[$col] = 'storage/' . $path;
            }
        }

        SoalModul::create($data);
        return back()->with('success', 'Soal berhasil ditambahkan!');
    }

    public function generateSoal(Request $request)
    {
        $validated = $request->validate([
            'jumlah' => 'required|integer|min:1',
            'kelompok' => 'required|string',
            'modul' => 'required|string',
        ]);

        $kelompok = KelompokSoal::where('judul', $validated['kelompok'])->firstOrFail();

        // Cek apakah semua soal_text null -> pakai gambar
        $allTextNull = empty($kelompok->soal1_text)
            && empty($kelompok->soal2_text)
            && empty($kelompok->soal3_text)
            && empty($kelompok->soal4_text)
            && empty($kelompok->soal5_text);

        $soalMap = $allTextNull ? [
            'A' => $kelompok->soal1_img,
            'B' => $kelompok->soal2_img,
            'C' => $kelompok->soal3_img,
            'D' => $kelompok->soal4_img,
            'E' => $kelompok->soal5_img,
        ] : [
            'A' => $kelompok->soal1_text,
            'B' => $kelompok->soal2_text,
            'C' => $kelompok->soal3_text,
            'D' => $kelompok->soal4_text,
            'E' => $kelompok->soal5_text,
        ];

        // Validasi minimal
        foreach ($soalMap as $k => $v) {
            if (is_null($v) || $v === '') {
                return back()->with('error', "Kolom soal {$k} kosong. Isi semua atau set semua dari sumber lain (text/img).");
            }
        }

        // Pastikan proses tidak timeout
        set_time_limit(0);

        DB::beginTransaction();
        try {
            for ($i = 1; $i <= $validated['jumlah']; $i++) {
                // 1) acak key dan ambil nilai
                $keys = array_keys($soalMap);
                shuffle($keys);

                $shuffled = [];
                foreach ($keys as $k) {
                    $shuffled[$k] = $soalMap[$k];
                }

                // 2) pilih satu key asli yang hilang (jawaban benar)
                $missingKeys = array_keys($soalMap); // ['A','B','C','D','E']
                $missingKey = $missingKeys[array_rand($missingKeys)];
                $missingValue = $soalMap[$missingKey];

                // 3) hapus entry yang hilang dari versi acak
                unset($shuffled[$missingKey]);

                // 4) siapkan array nilai yang tersisa (4 item)
                $remainingValues = array_values($shuffled); // 4 items

                // 5) buat array final panjang 5 yang berisi 4 gambar + 1 null di posisi acak
                $final = array_fill(0, 5, null); // index 0..4
                $nullPos = rand(0, 4); // posisi kosong acak
                $idx = 0;
                for ($pos = 0; $pos < 5; $pos++) {
                    if ($pos === $nullPos) {
                        $final[$pos] = null;
                    } else {
                        $final[$pos] = $remainingValues[$idx] ?? null;
                        $idx++;
                    }
                }

                if ($allTextNull) {
                    // Mode gambar: simpan j1..j5 sesuai posisi final (salah satu null)
                    $soal = SoalModul::create([
                        'no' => $i,
                        'modul' => $validated['modul'],
                        'kelompok' => $validated['kelompok'],
                        'soal2' => null,
                        'j1' => $final[0],
                        'j2' => $final[1],
                        'j3' => $final[2],
                        'j4' => $final[3],
                        'j5' => $final[4],
                    ]);
                } else {
                    // Mode teks: seperti sebelumnya (soal2 berisi string acak)
                    $soal2 = implode('', array_values($shuffled));
                    $soal = SoalModul::create([
                        'no' => $i,
                        'modul' => $validated['modul'],
                        'kelompok' => $validated['kelompok'],
                        'soal2' => $soal2,
                        'j1' => $soalMap['A'],
                        'j2' => $soalMap['B'],
                        'j3' => $soalMap['C'],
                        'j4' => $soalMap['D'],
                        'j5' => $soalMap['E'],
                    ]);
                }

                // Simpan kunci jawaban (simpan key yang dihapus, misal 'B')
                KunciJawaban::create([
                    'modul_jawaban' => $validated['modul'],
                    'jawaban_benar' => $missingKey,
                    'poin_jawaban' => null,
                    'nomor_jawaban' => $i,
                ]);

                // Tambahkan delay agar server tidak error kalau jumlah besar
                usleep(100000); // 0.1 detik per soal
            }

            DB::commit();
            $mode = $allTextNull ? 'gambar (acak, satu slot null acak)' : 'teks';
            return back()->with('success', "{$validated['jumlah']} soal ({$mode}) berhasil digenerate dengan kunci jawaban!");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal generate soal: ' . $e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        $soal = SoalModul::findOrFail($id);

        $validated = $request->validate([
            'no' => 'required',
            'modul' => 'required',
            'kelompok' => 'required',
            'soal2' => 'nullable',
            'j1' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'j2' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'j3' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'j4' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'j5' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $data = $validated;

        // 🟢 Jika ada gambar baru, upload dan ganti
        foreach (['j1', 'j2', 'j3', 'j4', 'j5'] as $col) {
            if ($request->hasFile($col)) {
                // Hapus file lama (opsional, bisa di-skip kalau mau keep)
                if (!empty($soal->$col) && file_exists(public_path($soal->$col))) {
                    unlink(public_path($soal->$col));
                }

                $path = $request->file($col)->store('soal_images', 'public');
                $data[$col] = 'storage/' . $path;
            } else {
                // Kalau gak diubah, tetap pakai gambar lama
                $data[$col] = $soal->$col;
            }
        }

        $soal->update($data);

        return redirect()
            ->route('soal.index')
            ->with('success', 'Soal berhasil diperbarui!');
    }


    public function destroy($id)
    {
        // 🔎 Coba cari di SoalModul dulu
        $item = SoalModul::find($id);

        // Jika tidak ada di SoalModul, cari di SoalMultipleChoice
        if (!$item) {
            $item = SoalMultipleChoice::find($id);
            $source = 'multiple';
        } else {
            $source = 'modul';
        }

        // Jika tetap tidak ada di kedua tabel
        if (!$item) {
            return back()->with('error', '❌ Soal tidak ditemukan di database!');
        }

        // 🧹 Hapus file-file gambar jika ada
        foreach (['j1', 'j2', 'j3', 'j4', 'j5'] as $col) {
            if (!empty($item->$col)) {
                $path = public_path($item->$col);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        // 🗑️ Hapus data dari database
        $item->delete();

        // ✅ Kirim notifikasi sukses
        return back()->with('success', "Soal dari tabel {$source} berhasil dihapus!");
    }

    public function show($modul, $type_template)
    {
        // 🟦 ambil data soal tergantung type template
        if ($type_template === 'angka-hilang') {
            $data = DB::table('soal_modul')
                ->where('modul', $modul)
                ->orderBy('no', 'asc')
                ->get(['no', 'soal2 as soal']);
        } elseif ($type_template === 'multiple-chois') {
            $data = DB::table('soal_multiple_choice')
                ->where('modul', $modul)
                ->orderBy('no', 'asc')
                ->get(['no', 'soal']);
        } elseif ($type_template === 'tanpa-kembali') {
            $data = DB::table('soal_multiple_choice')
                ->where('modul', $modul)
                ->orderBy('no', 'asc')
                ->get(['no', 'soal']);
        } else {
            return redirect()->back()->with('error', 'Type template tidak valid.');
        }

        // 🟨 KHUSUS untuk type_template === 'tanpa-kembali'
        if ($type_template === 'tanpa-kembali') {
            // Ambil semua kunci jawaban yang sudah tersimpan
            $kunci = \App\Models\KunciJawaban::where('modul_jawaban', $modul)->get();

            // Buat array dengan key kombinasi "no_opsi"
            $existingPoin = [];
            foreach ($kunci as $item) {
                $key = $item->nomor_jawaban . '_' . $item->jawaban_benar;
                $existingPoin[$key] = $item->poin_jawaban;
            }

            // Render view khusus tanpa-kembali
            return view('admin.kunci_jawaban_tanpa-kembali', compact('data', 'modul', 'type_template', 'existingPoin'));
        }

        // 🟩 Selain itu, tetap pakai format lama
        $kunci = \App\Models\KunciJawaban::where('modul_jawaban', $modul)
            ->get()
            ->keyBy('nomor_jawaban');

        $existingPoin = $kunci->mapWithKeys(function ($item) {
            return [$item->nomor_jawaban => $item->poin_jawaban];
        });

        return view('admin.kunci_jawaban', compact('data', 'modul', 'type_template', 'kunci', 'existingPoin'));
    }
    public function simpan(Request $request)
    {
        $modul = $request->modul_jawaban;
        $jawabanBenar = $request->jawaban_benar;
        $poinJawaban = $request->poin_jawaban;

        foreach ($jawabanBenar as $nomor => $jawaban) {
            // cek apakah sudah ada data untuk modul + nomor soal ini
            $existing = KunciJawaban::where('modul_jawaban', $modul)
                ->where('nomor_jawaban', $nomor)
                ->first();

            if ($existing) {
                // update hanya kalau ada input baru
                $existing->update([
                    'jawaban_benar' => $jawaban ?: $existing->jawaban_benar,
                    'poin_jawaban'  => $poinJawaban[$nomor] ?: $existing->poin_jawaban,
                ]);
            } else {
                // buat baru kalau belum ada
                KunciJawaban::create([
                    'modul_jawaban' => $modul,
                    'jawaban_benar' => $jawaban,
                    'poin_jawaban'  => $poinJawaban[$nomor] ?? 0,
                    'nomor_jawaban' => $nomor,
                ]);
            }
        }

        return back()->with('success', 'Kunci jawaban berhasil disimpan / diperbarui!');
    }
    public function simpanTanpaKembali(Request $request)
    {
        $modul = $request->modul_jawaban;
        $poinJawaban = $request->poin_jawaban;

        foreach ($poinJawaban as $nomor => $opsiList) {
            foreach ($opsiList as $opsi => $poin) {
                // lewati kalau kosong atau null
                if ($poin === null || $poin === '') continue;

                // cek apakah sudah ada data untuk modul + nomor + opsi ini
                $existing = \App\Models\KunciJawaban::where('modul_jawaban', $modul)
                    ->where('nomor_jawaban', $nomor)
                    ->where('jawaban_benar', $opsi)
                    ->first();

                if ($existing) {
                    $existing->update([
                        'poin_jawaban' => $poin,
                    ]);
                } else {
                    \App\Models\KunciJawaban::create([
                        'modul_jawaban' => $modul,
                        'nomor_jawaban' => $nomor,
                        'jawaban_benar' => $opsi,
                        'poin_jawaban'  => $poin,
                    ]);
                }
            }
        }

        // 🟢 langsung redirect ke halaman yang sama biar data ke-refresh
        return back()->with('success', 'Kunci jawaban berhasil disimpan / diperbarui!');
    }

    public function importWord(Request $request)
    {
        $request->validate([
            'word_file' => 'required|file|mimes:docx|max:20480',
        ]);

        $file = $request->file('word_file');
        $phpWord = IOFactory::load($file->getPathName());
        $sections = $phpWord->getSections();

        $currentData = [];
        $count = 0;

        foreach ($sections as $section) {
            $elements = $section->getElements();

            foreach ($elements as $element) {
                if (!method_exists($element, 'getRows')) continue; // hanya tabel

                foreach ($element->getRows() as $row) {

                    $cells = $row->getCells();
                    if (count($cells) < 2) continue;

                    // Ambil key (kolom kiri)
                    $keyElement = $cells[0]->getElements()[0] ?? null;
                    $key = $keyElement && method_exists($keyElement, 'getText')
                        ? strtolower(trim(strip_tags($keyElement->getText())))
                        : null;

                    if (!$key) continue;

                    // Ambil value (kolom kanan)
                    $valElements = $cells[1]->getElements();

                    $content = '';

                    // 🔥 Ambil semua teks + gambar base64 jadi satu HTML string
                    foreach ($valElements as $v) {

                        if (method_exists($v, 'getText')) {
                            $text = trim($v->getText());
                            if ($text !== '') {
                                $content .= '<p>' . e($text) . '</p>';
                            }
                        } elseif (method_exists($v, 'getImageStringData')) {
                            $ext = $v->getImageExtension() ?? 'png';
                            $dataImg = $v->getImageStringData();

                            // langsung embed base64
                            $base64 = base64_encode(base64_decode($dataImg));
                            $mime = match (strtolower($ext)) {
                                'jpg', 'jpeg' => 'image/jpeg',
                                'gif' => 'image/gif',
                                'webp' => 'image/webp',
                                default => 'image/png',
                            };

                            $content .= "<img src='data:{$mime};base64,{$base64}' alt='gambar' style='max-width:400px;display:block;margin:6px 0;'>";
                        }
                    }

                    // Jika ketemu "no" baru → simpan data sebelumnya
                    if ($key === 'no' && !empty($currentData)) {
                        SoalMultipleChoice::create([
                            'no' => strip_tags($currentData['no'] ?? null),
                            'soal' => $currentData['soal'] ?? '',
                            'modul' => strip_tags($currentData['modul'] ?? 'default'),
                            'pembahasan' => $currentData['pembahasan'] ?? null,
                            'j1' => $currentData['j1'] ?? null,
                            'j2' => $currentData['j2'] ?? null,
                            'j3' => $currentData['j3'] ?? null,
                            'j4' => $currentData['j4'] ?? null,
                            'j5' => $currentData['j5'] ?? null,
                        ]);
                        $count++;
                        $currentData = [];
                    }

                    // Simpan hasil (no & modul → text only)
                    if (in_array($key, ['no', 'modul'])) {
                        $textOnly = '';
                        foreach ($valElements as $v) {
                            if (method_exists($v, 'getText')) {
                                $textOnly .= ' ' . trim($v->getText());
                            }
                        }
                        $currentData[$key] = trim($textOnly);
                    } else {
                        // kolom lain (soal, j1–j5, pembahasan)
                        $currentData[$key] = trim($content);
                    }
                }
            }
        }

        // Simpan soal terakhir
        if (!empty($currentData)) {
            SoalMultipleChoice::create([
                'no' => strip_tags($currentData['no'] ?? null),
                'soal' => $currentData['soal'] ?? '',
                'modul' => strip_tags($currentData['modul'] ?? 'default'),
                'pembahasan' => $currentData['pembahasan'] ?? null,
                'j1' => $currentData['j1'] ?? null,
                'j2' => $currentData['j2'] ?? null,
                'j3' => $currentData['j3'] ?? null,
                'j4' => $currentData['j4'] ?? null,
                'j5' => $currentData['j5'] ?? null,
            ]);
            $count++;
        }

        return back()->with('success', "✅ Berhasil import {$count} soal! Semua gambar otomatis ter-embed base64 di kolom HTML.");
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        $type_template = $request->type_template; // ambil dari form


        if (!$ids || count($ids) === 0) {
            return back()->with('error', 'Tidak ada data yang dipilih!');
        }

        // ===============================
        // LOGIKA DELETE BERDASARKAN TYPE
        // ===============================

        if ($type_template == 'multiple-chois' || $type_template == 'panduan' || $type_template == 'tanpa-kembali') {

            // hapus dari tabel multiple choice
            SoalMultipleChoice::whereIn('id', $ids)->delete();
        } else {


            // hapus dari tabel soal_modul
            SoalModul::whereIn('id', $ids)->delete();
        }

        return back()->with('success', 'Berhasil menghapus ID: ' . implode(', ', $ids));
    }
}
