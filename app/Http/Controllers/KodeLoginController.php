<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Kode;
use App\Models\KumpulanModul;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class KodeLoginController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        $user->name = $request->username;
        $user->email = $request->email;

        // Password hash
        $user->password = Hash::make($request->password);

        // Password asli
        $user->lihatpw = $request->password;

        $user->save();

        return back()->with('success', 'Akun berhasil diperbarui');
    }
    public function index()
    {
        return view('utama.pages-code');
    }

    public function check(Request $request)
    {
        $request->validate([
            'kode' => 'required|string'
        ]);


        $kodeInput = strtoupper(trim($request->kode));
        $kode = \App\Models\Kode::where('kode', $kodeInput)->first();

        // 1️⃣ Cek kode
        if (!$kode) {
            return back()->with('error', 'Kode tidak valid!');
        }

        // 2️⃣ Cek tanggal
        $today = \Carbon\Carbon::today();
        if ($today->lt(\Carbon\Carbon::parse($kode->tanggal_mulai)) || $today->gt(\Carbon\Carbon::parse($kode->tanggal_selesai))) {
            return back()->with('error', 'Kode tidak berlaku pada tanggal ini!');
        }

        // 3️⃣ Cek modul
        $modul = \App\Models\KumpulanModul::find($kode->modul_id);
        if (!$modul) {
            return back()->with('error', 'Modul tidak ditemukan!');
        }

        // ✅ Semua benar — simpan ke session (bukan auth)
        session([
            'kode_login' => $kode->kode,
            'modul_id' => $modul->id,
            'modul_nama' => $modul->nama,
            'status' => $kode->status,
            'waktu' => $kode->waktu,
            'login_time' => now()
        ]);


        return redirect()->route('ujian');
    }
    public function logoutTest()
    {
        // ambil id user yang sedang login
        $userId = Auth::id();

        // update kolom status jadi pending
        DB::table('users')->where('id', $userId)->update([
            'status' => 'pending'
        ]);

        // hapus session ujian
        Session::flush();

        // logout auth agar login habis
        Auth::logout();

        // redirect ke halaman utama
        return redirect('/')->with('success', 'Anda telah keluar dari ujian.');
    }
    public function history()
    {
        $user = Auth::user();

        // Pisahkan history berdasarkan koma
        $riwayat = explode(',', $user->history ?? '');

        return view('utama.history', compact('riwayat', 'user'));
    }
}
