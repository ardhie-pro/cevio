<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $data = DB::table('kode')
            // Ambil nama peserta dari jawaban_user
            ->leftJoin('jawaban_user', function ($join) {
                $join->on('jawaban_user.user_id', '=', 'kode.kode')
                    ->where('jawaban_user.modul', '=', 'Nama-Peserta');
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

        return view('admin.laporan.index', compact('data'));
    }



    public function show($kode)
    {
        // 🔹 Ambil semua modul
        $modulList = DB::table('tarik_modul')
            ->select('modul', 'type_template')
            ->orderBy('modul')
            ->get();

        $data = [];

        foreach ($modulList as $modulItem) {
            $modul = $modulItem->modul;
            $typeTemplate = $modulItem->type_template;

            // Ambil kunci & jawaban
            $kunci = DB::table('kunci_jawaban')
                ->where('modul_jawaban', $modul)
                ->get();

            $jawaban = DB::table('jawaban_user')
                ->where('user_id', $kode)
                ->where('modul', $modul)
                ->get();

            if ($jawaban->isEmpty()) continue;

            $hasil = [];
            $totalPoin = 0;
            $totalBenar = 0;
            $totalSalah = 0;

            foreach ($jawaban as $row) {
                // 🟩 Mode TANPA-KEMBALI → ambil poin berdasarkan opsi jawaban
                if ($typeTemplate === 'tanpa-kembali') {
                    $kunciOpsi = $kunci
                        ->where('nomor_jawaban', $row->no)
                        ->where('jawaban_benar', strtoupper(trim($row->jawaban)))
                        ->first();

                    $poin = $kunciOpsi->poin_jawaban ?? 0;
                    $totalPoin += $poin;

                    $hasil[] = [
                        'no' => $row->no,
                        'jawaban_user' => $row->jawaban ?? '-',
                        'jawaban_benar' => $kunciOpsi->jawaban_benar ?? '-',
                        'poin' => $poin,
                        'status' => $poin > 0 ? 'benar' : 'salah',
                    ];
                }
                // 🟨 Mode lain → tetap sistem benar/salah
                else {
                    $kunciSoal = $kunci->firstWhere('nomor_jawaban', $row->no);
                    $jawabanBenar = $kunciSoal->jawaban_benar ?? '-';
                    $poin = 0;
                    $status = null;

                    if ($kunciSoal) {
                        if (strtoupper(trim($row->jawaban)) === strtoupper(trim($kunciSoal->jawaban_benar))) {
                            $status = 'benar';
                            $poin = $kunciSoal->poin_jawaban;
                            $totalPoin += $poin;
                            $totalBenar++;
                        } else {
                            $status = 'salah';
                            $totalSalah++;
                        }
                    }

                    $hasil[] = [
                        'no' => $row->no,
                        'jawaban_user' => $row->jawaban,
                        'jawaban_benar' => $jawabanBenar,
                        'poin' => $poin,
                        'status' => $status,
                    ];
                }
            }

            // Simpan hasil
            $data[$modul] = [
                'soal' => $hasil,
                'total_poin' => $totalPoin,
            ];

            // Tambah rekap hanya untuk angka-hilang
            if ($typeTemplate === 'angka-hilang') {
                $data[$modul]['rekap'] = [
                    'total_soal' => $kunci->count(),
                    'dijawab' => count($hasil),
                    'benar' => $totalBenar,
                    'salah' => $totalSalah,
                ];
            }
        }
        // ==========================
        // 🔥 Rekap Global Angka-Hilang
        // ==========================
        $rekapGlobal = [
            'total_soal' => 0,
            'dijawab' => 0,
            'benar' => 0,
            'salah' => 0,
        ];

        foreach ($data as $modul => $detail) {
            if (isset($detail['rekap'])) {
                $rekapGlobal['total_soal'] += $detail['rekap']['total_soal'] ?? 0;
                $rekapGlobal['dijawab'] += $detail['rekap']['dijawab'] ?? 0;
                $rekapGlobal['benar'] += $detail['rekap']['benar'] ?? 0;
                $rekapGlobal['salah'] += $detail['rekap']['salah'] ?? 0;
            }
        }

        return view('admin.laporan.show', compact('kode', 'data', 'rekapGlobal'));
    }

    public function detail($kode, $user_id)
    {
        // Ambil jawaban user berdasarkan kode dan user_id
        $jawaban = DB::table('jawaban_user')
            ->where('kode', $kode)
            ->where('user_id', $user_id)
            ->orderBy('modul')
            ->orderBy('no')
            ->get();

        // Ambil kunci jawaban
        $kunci = DB::table('kunci_jawaban')->get()->keyBy(function ($item) {
            return $item->modul_jawaban . '-' . $item->nomor_jawaban;
        });

        // Bandingkan jawaban user dengan kunci
        $laporan = $jawaban->map(function ($row) use ($kunci) {
            $key = $row->modul . '-' . $row->no;
            $row->jawaban_benar = $kunci[$key]->jawaban_benar ?? '-';
            $row->status = ($row->jawaban_user == ($kunci[$key]->jawaban_benar ?? '')) ? 'Benar' : 'Salah';
            $row->poin = ($row->status == 'Benar') ? ($kunci[$key]->poin_jawaban ?? 0) : 0;
            return $row;
        });

        $totalPoin = $laporan->sum('poin');

        return view('admin.laporan.detail', compact('laporan', 'kode', 'user_id', 'totalPoin'));
    }

    public function hasiluser($kode)
    {
        // 🔹 Ambil semua modul
        $modulList = DB::table('tarik_modul')
            ->select('modul', 'type_template')
            ->orderBy('modul')
            ->get();

        $data = [];

        foreach ($modulList as $modulItem) {
            $modul = $modulItem->modul;
            $typeTemplate = $modulItem->type_template;

            // Ambil kunci & jawaban
            $kunci = DB::table('kunci_jawaban')
                ->where('modul_jawaban', $modul)
                ->get();

            $jawaban = DB::table('jawaban_user')
                ->where('user_id', $kode)
                ->where('modul', $modul)
                ->get();

            if ($jawaban->isEmpty()) continue;

            $hasil = [];
            $totalPoin = 0;
            $totalBenar = 0;
            $totalSalah = 0;

            foreach ($jawaban as $row) {
                // 🟩 Mode TANPA-KEMBALI → ambil poin berdasarkan opsi jawaban
                if ($typeTemplate === 'tanpa-kembali') {
                    $kunciOpsi = $kunci
                        ->where('nomor_jawaban', $row->no)
                        ->where('jawaban_benar', strtoupper(trim($row->jawaban)))
                        ->first();

                    $poin = $kunciOpsi->poin_jawaban ?? 0;
                    $totalPoin += $poin;

                    $hasil[] = [
                        'no' => $row->no,
                        'jawaban_user' => $row->jawaban ?? '-',
                        'jawaban_benar' => $kunciOpsi->jawaban_benar ?? '-',
                        'poin' => $poin,
                        'status' => $poin > 0 ? 'benar' : 'salah',
                    ];
                }
                // 🟨 Mode lain → tetap sistem benar/salah
                else {
                    $kunciSoal = $kunci->firstWhere('nomor_jawaban', $row->no);
                    $jawabanBenar = $kunciSoal->jawaban_benar ?? '-';
                    $poin = 0;
                    $status = null;

                    if ($kunciSoal) {
                        if (strtoupper(trim($row->jawaban)) === strtoupper(trim($kunciSoal->jawaban_benar))) {
                            $status = 'benar';
                            $poin = $kunciSoal->poin_jawaban;
                            $totalPoin += $poin;
                            $totalBenar++;
                        } else {
                            $status = 'salah';
                            $totalSalah++;
                        }
                    }

                    $hasil[] = [
                        'no' => $row->no,
                        'jawaban_user' => $row->jawaban,
                        'jawaban_benar' => $jawabanBenar,
                        'poin' => $poin,
                        'status' => $status,
                    ];
                }
            }

            // Simpan hasil
            $data[$modul] = [
                'soal' => $hasil,
                'total_poin' => $totalPoin,
            ];

            // Tambah rekap hanya untuk angka-hilang
            if ($typeTemplate === 'angka-hilang') {
                $data[$modul]['rekap'] = [
                    'total_soal' => $kunci->count(),
                    'dijawab' => count($hasil),
                    'benar' => $totalBenar,
                    'salah' => $totalSalah,
                ];
            }
        }
        // ==========================
        // 🔥 Rekap Global Angka-Hilang
        // ==========================
        $rekapGlobal = [
            'total_soal' => 0,
            'dijawab' => 0,
            'benar' => 0,
            'salah' => 0,
        ];

        foreach ($data as $modul => $detail) {
            if (isset($detail['rekap'])) {
                $rekapGlobal['total_soal'] += $detail['rekap']['total_soal'] ?? 0;
                $rekapGlobal['dijawab'] += $detail['rekap']['dijawab'] ?? 0;
                $rekapGlobal['benar'] += $detail['rekap']['benar'] ?? 0;
                $rekapGlobal['salah'] += $detail['rekap']['salah'] ?? 0;
            }
        }

        return view('utama.show', compact('kode', 'data', 'rekapGlobal'));
    }
}
