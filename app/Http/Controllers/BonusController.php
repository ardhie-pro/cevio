<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EventKru;
use App\Models\BonusRekap;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BonusController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tahun dari GET, default tahun sekarang, atau 'all'
        $tahun = $request->input('tahun', date('Y'));

        $users = User::whereHas('eventKru', function ($q) use ($tahun) {
            if ($tahun !== 'all') {
                $q->whereYear('tanggal_kerja', $tahun);
            }
        })
            ->with(['eventKru' => function ($q) use ($tahun) {
                if ($tahun !== 'all') {
                    $q->whereYear('tanggal_kerja', $tahun);
                }
                $q->with(['event', 'role']);
            }])
            ->get();

        $rekap = BonusRekap::all()->keyBy('user_id');

        return view('bonus.index', compact('users', 'rekap', 'tahun'));
    }


    public function save(Request $request)
    {
        $data = $request->bonus;

        foreach ($data as $userId => $row) {
            DB::table('bonus_rekap')->updateOrInsert(
                ['user_id' => $userId],
                [
                    'bonus' => $row['bonus'] ?? 0,
                    'catatan' => $row['catatan'] ?? '',
                    'updated_by' => Auth::user()->name,
                    'updated_at' => now(),
                ]
            );
        }

        return redirect()->back()->with('success', 'Bonus berhasil disimpan.');
    }

    public function download(Request $request)
    {
        $tahun = $request->input('tahun');

        $data = DB::table('bonus_rekap')
            ->join('users', 'users.id', '=', 'bonus_rekap.user_id')
            ->join('event_kru', 'event_kru.user_id', '=', 'users.id');

        // Kalau bukan ALL → filter tahun
        if ($tahun !== 'all') {
            $data->whereYear('event_kru.tanggal_kerja', $tahun);
        }

        $data = $data->select(
            'users.name',
            'bonus_rekap.bonus',
            'users.bank',
            'users.cabang',
            'users.no_rek',
            'users.nama_npwp',
            'users.npwp',
            'users.alamat_npwp',
            'users.nik',
            'users.alamat'
        )
            ->distinct()
            ->get();

        $pdf = \PDF::loadView('bonus.rekap-pdf', compact('data', 'tahun'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("rekap_bonus_{$tahun}_" . date('YmdHis') . '.pdf');
    }
}
