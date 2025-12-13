<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\EventKru;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleShift;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function edit()
    {
        return view('user.profile', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email',

            'bank' => 'nullable|string',
            'cabang' => 'nullable|string',
            'no_rek' => 'nullable|string',

            'nik' => 'nullable|string',
            'nama_npwp' => 'nullable|string',
            'npwp' => 'nullable|string',
            'alamat_npwp' => 'nullable|string',

            'alamat' => 'nullable|string',

            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = auth()->user();

        $data = $request->except([
            'name',
            'password',
            'password_confirmation',
        ]);

        // update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $data['lihatpw']  = $request->password;
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
