<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Kode;
use Illuminate\Support\Str;

use App\Models\KumpulanModul;

class KodeGeneratorController extends Controller
{
   public function index(Request $request)
{
    $query = DB::table('kode')
        ->join('kumpulan_modul', 'kode.modul_id', '=', 'kumpulan_modul.id')
        ->select('kode.*', 'kumpulan_modul.nama as nama_modul')
        ->where('kode.status', 0); // hanya status 0

    // 🔍 Filter tanggal_mulai
    if ($request->filled('tanggal_mulai')) {
        $query->whereDate('kode.tanggal_mulai', $request->tanggal_mulai);
    }

    // 🔍 Filter modul
    if ($request->filled('modul_id')) {
        $query->where('kode.modul_id', $request->modul_id);
    }

    $data = $query->orderBy('kode.tanggal_mulai', 'desc')->get();
    $modul = DB::table('kumpulan_modul')->select('id', 'nama')->get();

    return view('admin.kode', compact('data', 'modul'));
}


    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'modul_id' => 'required|exists:kumpulan_modul,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $kodeList = [];
        for ($i = 0; $i < $request->jumlah; $i++) {
            $kodeList[] = [
                'kode' => strtoupper(Str::random(10)),
                'modul_id' => $request->modul_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status' => 0, // ✅ otomatis status 0
                'waktu' => null, // ✅ otomatis null
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Kode::insert($kodeList);

        return back()->with('success', count($kodeList) . ' kode berhasil dibuat!');
    }

    public function destroy($id)
    {
        $kode = Kode::findOrFail($id);
        $kode->delete();

        return back()->with('success', 'Data kode berhasil dihapus.');
    }
}
