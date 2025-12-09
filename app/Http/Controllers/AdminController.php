<?php

namespace App\Http\Controllers;

use App\Models\grupModel;
use App\Models\SoalModul;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Halaman dasboard admin
    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'active'; // atau status lain sesuai kebutuhanmu
        $user->save();

        return back()->with('success', 'Status user berhasil diperbarui!');
    }
    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();

        // Kirim ke view
        return view('admin.dashboard', compact('users'));
    }
    public function akun()
    {
        $grup = grupModel::all();

        $admins = User::where('status', 'admin')
            ->orderBy('id', 'desc')
            ->get(); // ← ini wajib

        $reviews = User::where('status', 'review')
            ->orderBy('id', 'desc')
            ->get(); // ← ini juga

        return view('admin.akun', compact('admins', 'reviews', 'grup'));
    }
    public function user()
    {
        $grup = grupModel::all();
        $user = User::where('status', 'user')
            ->orderBy('id', 'desc')
            ->get(); // ← ini wajib
        $userb = User::all();
        return view('admin.user', compact('userb', 'grup'));
    }
    // Ambil soal berdasarkan modul & nomor
    public function getSoal($modul, $no)
    {
        $soal = SoalModul::where('modul', $modul)
            ->where('no', $no)
            ->first();

        $kelompok = \App\Models\KelompokSoal::where('judul', $soal->kelompok)->first();

        if (!$soal) {
            return response()->json(['done' => true]); // kalau soal habis
        }


        return response()->json([
            'done' => false,
            'soal' => $soal,
            'kelompok' => $kelompok,
        ]);
    }

    // Simpan jawaban user
    public function simpanJawaban(Request $request)
    {
        // Cek apakah jawaban sudah pernah disimpan
        $cek = DB::table('jawaban_user')
            ->where('user_id', $request->kodeLogin)
            ->where('modul', $request->modul)
            ->where('no', $request->no)
            ->first();

        if ($cek) {
            // Kalau sudah ada, update jawaban
            DB::table('jawaban_user')
                ->where('user_id', $request->kodeLogin)
                ->where('modul', $request->modul)
                ->where('no', $request->no)
                ->update([
                    'jawaban' => $request->jawaban,
                    'updated_at' => now(),
                ]);
        } else {
            // Kalau belum ada, insert baru
            DB::table('jawaban_user')->insert([
                'user_id' => $request->kodeLogin,
                'modul' => $request->modul,
                'no' => $request->no,
                'jawaban' => $request->jawaban,
                'created_at' => now(),
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
    public function updateUser(Request $request, User $user)
    {

        $request->validate([
            'status' => 'required|string',
            'role' => 'required|string',
            'grup' => 'nullable|string',
        ]);



        $user->update([
            'status' => $request->status,
            'grup' => $request->grup,
            'role' => $request->role,
        ]);

        return back()->with('success', 'Data user berhasil diperbarui.');
    }
    public function galeriStore(Request $request)
    {
        $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 🟢 Simpan ke folder soal_images
        $path = $request->file('img')->store('soal_images', 'public');

        DB::table('img_soal_random')->insert([
            'img' => $path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Gambar berhasil ditambahkan.');
    }

    public function galeriUpdate(Request $request, $id)
    {
        $request->validate([
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('img')) {
            // 🟢 Simpan ke folder soal_images
            $path = $request->file('img')->store('soal_images', 'public');

            DB::table('img_soal_random')->where('id', $id)->update([
                'img' => $path,
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Gambar berhasil diperbarui.');
    }

    public function galeriDelete($id)
    {
        $item = DB::table('img_soal_random')->where('id', $id)->first();

        if ($item && file_exists(storage_path('app/public/' . $item->img))) {
            unlink(storage_path('app/public/' . $item->img));
        }

        DB::table('img_soal_random')->where('id', $id)->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
    public function generateUser(Request $req)
    {
        $req->validate([
            'jumlah' => 'required|integer|min:1|max:1000'
        ]);

        $hasil = [];

        for ($i = 0; $i < $req->jumlah; $i++) {

            $passwordPlain = Str::random(10);
            $email = Str::lower(Str::random(8)) . '@gmail.com';
            $username = 'user_' . Str::random(6);

            $user = User::create([
                'name' => $username,
                'email' => $email,
                'password' => Hash::make($passwordPlain),
                'lihatpw' => $passwordPlain,
                'role' => 'active',
                'status' => 'user',
            ]);

            $hasil[] = $user;
        }

        $userb = User::orderBy('id', 'asc')->get();

        return view('admin.user', compact('hasil', 'userb'))
            ->with('success', $req->jumlah . ' user berhasil dibuat!');
    }

    // input akun di admin
    public function buatakun(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'grup'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:5',
            'status'    => 'required'
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'grup'     => $request->grup,
            'password'  => $request->lihatpw, // masukan ke lihat pw agar terllihat
            'password'  => Hash::make($request->password), // password terenkripsi
            'lihatpw'   => $request->password, // kalau kamu mau simpan plain (sesuai requestmu)
            'status'    => $request->status,
        ]);

        return back()->with('success', 'User berhasil ditambahkan!');
    }

    public function buatgrup(Request $request)
    {
        $request->validate([
            'nama_grup'      => 'required',
        ]);

        grupModel::create([
            'nama_grup'      => $request->nama_grup,
        ]);

        return back()->with('successgrup', 'Grup berhasil ditambahkan!');
    }

    // hapus grup
    public function hapusGrup($id)
    {
        grupModel::where('id', $id)->delete();

        return back()->with('successgrup', 'Grup berhasil dihapus!');
    }

    public function updateGrup(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->grup = $request->grup;   // isi kolom grup
        $user->save();

        return back()->with('success', 'Grup user berhasil diubah.');
    }

    public function hapusbGrup($id)
    {
        $user = User::findOrFail($id);
        $user->grup = null;   // hapus kolom grup saja
        $user->save();

        return back()->with('success', 'Grup user berhasil dihapus.');
    }
}
