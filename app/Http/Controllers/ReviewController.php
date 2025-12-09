<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\JawabanUser;
use App\Models\KunciJawaban;
use App\Models\Kode;
use Illuminate\Support\Facades\DB;
use App\Models\KumpulanModul;
use App\Models\TarikModul;
use Carbon\Carbon;

class ReviewController extends Controller
{
    // 🟢 Menampilkan semua kode
    public function index()
    {
        $data = User::where('status', 'user')->get();
        $datap = DB::table('kode')
            // Ambil nama peserta dari jawaban_user (kolom modul = 'Nama')
            ->leftJoin('jawaban_user', function ($join) {
                $join->on('jawaban_user.user_id', '=', 'kode.kode')
                    ->where('jawaban_user.modul', '=', 'Nama');
            })
            // Ambil nama modul dari kumpulan_modul
            ->leftJoin('kumpulan_modul', 'kumpulan_modul.id', '=', 'kode.modul_id')
            ->select(
                'kode.*',
                'jawaban_user.jawaban as nama_peserta',
                'kumpulan_modul.nama as nama_modul'
            )
            ->orderByRaw("CASE WHEN kode.status = 0 THEN 0 ELSE 1 END") // status 0 di atas
            ->orderBy('kode.id', 'desc')
            ->get();

        return view('review.tampilkanUser', compact('data'));
    }

    public function tampilkankode()
    {
        $datap = User::where('status', 'user')->get();
        $data = DB::table('kode')
            // Ambil nama peserta dari jawaban_user (kolom modul = 'Nama')
            ->leftJoin('jawaban_user', function ($join) {
                $join->on('jawaban_user.user_id', '=', 'kode.kode')
                    ->where('jawaban_user.modul', '=', 'Nama');
            })
            // Ambil nama modul dari kumpulan_modul
            ->leftJoin('kumpulan_modul', 'kumpulan_modul.id', '=', 'kode.modul_id')
            ->select(
                'kode.*',
                'jawaban_user.jawaban as nama_peserta',
                'kumpulan_modul.nama as nama_modul'
            )
            ->orderByRaw("CASE WHEN kode.status = 0 THEN 0 ELSE 1 END") // status 0 di atas
            ->orderBy('kode.id', 'desc')
            ->get();

        return view('review.index', compact('data'));
    }

    public function lihat()
    {
        $data = User::where('status', 'user')->get();
        $datap = DB::table('kode')
            // Ambil nama peserta dari jawaban_user (kolom modul = 'Nama')
            ->leftJoin('jawaban_user', function ($join) {
                $join->on('jawaban_user.user_id', '=', 'kode.kode')
                    ->where('jawaban_user.modul', '=', 'Nama');
            })
            // Ambil nama modul dari kumpulan_modul
            ->leftJoin('kumpulan_modul', 'kumpulan_modul.id', '=', 'kode.modul_id')
            ->select(
                'kode.*',
                'jawaban_user.jawaban as nama_peserta',
                'kumpulan_modul.nama as nama_modul'
            )
            ->orderByRaw("CASE WHEN kode.status = 0 THEN 0 ELSE 1 END") // status 0 di atas
            ->orderBy('kode.id', 'desc')
            ->get();

        return view('review.index', compact('data'));
    }

    // 🟢 Menampilkan modul dari kode yang diklik
    public function show($kode)
    {
        $kodeData = Kode::where('kode', $kode)->firstOrFail();
        $modul = KumpulanModul::find($kodeData->modul_id);

        if (!$modul) {
            return back()->with('error', 'Modul tidak ditemukan.');
        }

        $modulList = is_string($modul->modul_ids)
            ? json_decode($modul->modul_ids, true)
            : (is_array($modul->modul_ids) ? $modul->modul_ids : []);

        return view('review.show', compact('kodeData', 'modul', 'modulList'));
    }

    public function detail($kode, $modul)
    {
        $soal = TarikModul::where('modul', $modul)->first();
        if (!$soal) return back()->with('error', 'Soal tidak ditemukan.');

        $kodeData = Kode::where('kode', $kode)->first();
        if (!$kodeData) return back()->with('error', 'Kode tidak valid.');

        // Ambil jawaban user
        $jawaban_user = JawabanUser::where('user_id', $kode)
            ->where('modul', $modul)
            ->get()
            ->keyBy('no'); // biar bisa akses cepat: $jawaban_user[$no]->jawaban

        // Ambil kunci jawaban
        $kunci = KunciJawaban::where('modul_jawaban', $modul)
            ->pluck('jawaban_benar', 'nomor_jawaban')
            ->toArray(); // sama, biar akses cepat

        $ambilmodul = $soal->modul ?? null;

        switch ($soal->type_template) {
            case 'angka-hilang':
                $view = 'bahas.ujian-2_bahas';
                break;
            case 'multiple-chois':
                $view = 'bahas.ujian_bahas';
                break;
            case 'tanpa-kembali':
                $view = 'bahas.ujian-3_bahas';
                break;
            default:
                return back()->with('error', 'Tipe template tidak dikenali.');
        }

        return view($view, compact('soal', 'modul', 'kode', 'jawaban_user', 'kunci', 'ambilmodul'));
    }
}
