<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\SoalMultipleChoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SoalMultipleChoiceController extends Controller
{
    public function ujian(Request $request)
    {
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $modulId = session('modul_id');
        $status = session('status');
        $kodeLogin = session('kode_login');

        if (!$modulId) {
            return redirect()->route('kode.login')->with('error', 'Silakan masukkan kode terlebih dahulu!');
        }

        $modulData = \App\Models\KumpulanModul::find($modulId);
        if (!$modulData) {
            return redirect()->route('kode.login')->with('error', 'Data modul tidak ditemukan.');
        }

        $raw = $modulData->modul_ids;
        $modulArray = is_string($raw) ? json_decode($raw, true) ?? [] : (is_array($raw) ? $raw : []);
        if (empty($modulArray)) {
            return redirect()->route('kode.login')->with('error', 'Tidak ada modul untuk dikerjakan.');
        }

        $currentIndex = $status;
        if ($currentIndex >= count($modulArray)) {
            return view('utama.selesai');
        }

        $currentModul = $modulArray[$currentIndex];
        $soal = \App\Models\TarikModul::where('modul', $currentModul)->first();
        if (!$soal) {
            return back()->with('error', "Modul {$currentModul} tidak ditemukan di database.");
        }

        $modul = $currentModul;
        $ambilmodul = $raw;

        // 🔹 Ambil data kode login
        $kode = \App\Models\Kode::where('kode', $kodeLogin)->first();
        if (!$kode) {
            return redirect()->route('kode.login')->with('error', 'Kode tidak valid.');
        }

        // 🔹 Tentukan waktu selesai
        if (empty($kode->waktu)) {
            // Jika kolom waktu masih null → buat waktu selesai baru
            $durasiDetik = (int) ($soal->waktu ?? 0) + 10; // buffer 10 detik
            $waktuSelesai = $now->copy()->addSeconds($durasiDetik);

            $kode->update([
                'waktu' => $waktuSelesai->format('Y-m-d H:i:s'),
                'updated_at' => $now,
            ]);
        } else {
            // Jika sudah ada, pakai waktu sebelumnya
            $waktuSelesai = \Carbon\Carbon::parse($kode->waktu)->timezone('Asia/Jakarta');
        }

        // 🔹 Simpan di session agar bisa diambil di view & JS
        session(['waktu' => $waktuSelesai->format('Y-m-d H:i:s')]);

        $waktu = [
            'mulai' => $now->format('Y-m-d H:i:s'),
            'selesai' => $waktuSelesai->format('Y-m-d H:i:s'),
        ];

        // 🔹 Arahkan ke view sesuai tipe template
        switch ($soal->type_template) {
            case 'data-nama':
                return view('utama.pages-data', compact('modul', 'ambilmodul'));
            case 'istirahat':
                return view('utama.break', compact('modul', 'ambilmodul', 'waktu'));
            case 'panduan':
                return view('utama.pagependahuluan', compact('modul', 'ambilmodul', 'waktu'));
            case 'angka-hilang':
                return view('utama.ujian-2', compact('modul', 'ambilmodul', 'waktu'));
            case 'multiple-chois':
                return view('utama.ujian', compact('modul', 'ambilmodul', 'waktu'));
            case 'tanpa-kembali':
                return view('utama.ujian-3', compact('modul', 'ambilmodul', 'waktu'));
            default:
                return back()->with('error', 'Tipe template tidak dikenali.');
        }
    }


    public function nextModul()
    {
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $kodeLogin = session('kode_login');
        $modulId = session('modul_id');

        if (!$kodeLogin) {
            return redirect()->route('home')->with('error', 'Session tidak ditemukan. Silakan login ulang.');
        }

        // 🔹 Ambil data kode login
        $kode = \App\Models\Kode::where('kode', $kodeLogin)->first();
        if (!$kode) {
            return redirect()->route('home')->with('error', 'Kode tidak ditemukan di database.');
        }

        // 🔹 Ambil data modul
        $modulData = \App\Models\KumpulanModul::find($modulId);
        if (!$modulData) {
            return redirect()->route('home')->with('error', 'Data modul tidak ditemukan.');
        }

        // 🔹 Decode modul_ids
        $raw = $modulData->modul_ids;
        $modulArray = is_string($raw) ? json_decode($raw, true) ?? [] : (is_array($raw) ? $raw : []);
        if (empty($modulArray)) {
            return redirect()->route('home')->with('error', 'Tidak ada modul untuk dikerjakan.');
        }

        // 🔹 Hitung status baru
        $currentStatus = $kode->status ?? 0;
        $newStatus = $currentStatus + 1;

        // 🔹 Jika sudah habis semua modul
        // if ($newStatus >= count($modulArray)) {
        //     $kode->update(['status' => $newStatus, 'updated_at' => $now]);
        //     session(['status' => $newStatus]);
        //     return view('utama.selesai');
        // }

        if ($newStatus >= count($modulArray)) {

            $user = Auth::user(); // User yang login

            // Data baru yang mau ditambahkan ke history
            $historyBaru = $kode->kode;

            // Ambil history lama DARI USER
            $historyLama = $user->history;

            // Gabungkan kalau sudah ada isi
            if (!empty($historyLama)) {
                $historyUpdate = $historyLama . ', ' . $historyBaru;
            } else {
                $historyUpdate = $historyBaru;
            }

            // Update history user
            $user->update([
                'history' => $historyUpdate,
            ]);

            // Update status pada tabel $kode
            $kode->update([
                'status'   => $newStatus,
                'updated_at' => $now,
            ]);

            session(['status' => $newStatus]);

            return view('utama.selesai');
        }

        // 🔹 Ambil modul berikutnya
        $nextModul = $modulArray[$newStatus];
        $soal = \App\Models\TarikModul::where('modul', $nextModul)->first();

        if (!$soal) {
            return redirect()->route('home')->with('error', "Modul {$nextModul} tidak ditemukan di database.");
        }

        // 🔹 Hitung waktu baru berdasarkan durasi soal
        $durasiDetik = (int) ($soal->waktu ?? 0) + 10;
        $waktuSelesaiBaru = $now->copy()->addSeconds($durasiDetik);

        // 🔹 Update ke database
        $kode->update([
            'status' => $newStatus,
            'waktu' => $waktuSelesaiBaru,
            'updated_at' => $now,
        ]);

        // 🔹 Ambil ulang waktu dari database biar valid
        $kode = \App\Models\Kode::where('kode', $kodeLogin)->first();

        // 🔹 Simpan waktu dan status ke session
        session([
            'status' => $kode->status,
            'waktu' => $kode->waktu, // waktu real dari database
        ]);

        // 🔹 Redirect ke halaman ujian
        return redirect()->route('ujian')->with('success', 'Berhasil lanjut ke modul berikutnya.');
    }


    public function index()
    {
        $soal = SoalMultipleChoice::all();
        return view('admin.soal_multiple.index', compact('soal'));
    }

    public function create()
    {
        return view('soal_multiple.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no' => 'required',
            'soal' => 'required',
            'modul' => 'required',
            'pembahasan' => 'nullable',
            'j1' => 'nullable|string',
            'j2' => 'nullable|string',
            'j3' => 'nullable|string',
            'j4' => 'nullable|string',
            'j5' => 'nullable|string',
        ]);


        SoalMultipleChoice::create($validated);

        return back()->with('success', 'Soal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $soal = SoalMultipleChoice::findOrFail($id);
        return view('soal_multiple.edit', compact('soal'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'no' => 'required',
            'soal' => 'required',
            'modul' => 'required',
            'pembahasan' => 'nullable',
            'j1' => 'nullable|string',
            'j2' => 'nullable|string',
            'j3' => 'nullable|string',
            'j4' => 'nullable|string',
            'j5' => 'nullable|string',
        ]);

        $soal = SoalMultipleChoice::findOrFail($id);
        $soal->update($validated);

        return back()->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        SoalMultipleChoice::destroy($id);
        return redirect()->route('soal-multiple.index')->with('success', 'Soal berhasil dihapus!');
    }
    public function getSoalByModul($modul)
    {
        $soal = \App\Models\SoalMultipleChoice::where('modul', $modul)
            ->orderBy('no', 'asc')
            ->get(['no', 'soal', 'j1', 'j2', 'j3', 'j4', 'j5', 'pembahasan', 'check']); // ambil jawaban

        return response()->json($soal);
    }

    public function getJawaban($modul, $kodeLogin)
    {
        $jawaban = DB::table('jawaban_user')
            ->where('modul', $modul)
            ->where('user_id', $kodeLogin)
            ->select('no', 'jawaban')
            ->get(); // hasil: [{no: 1, jawaban: 'A'}, {no: 2, jawaban: 'C'}, ...]

        return response()->json($jawaban);
    }
}
