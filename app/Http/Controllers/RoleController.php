<?php

namespace App\Http\Controllers;

use App\Models\RoleShift;
use App\Models\Role;



use Illuminate\Http\Request;

class RoleController extends Controller
{
    // tampil semua role
    public function index()
    {
        $roles = Role::with('shifts')->get();
        return view('admin.role.index', compact('roles'));
    }

    // simpan role baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_role' => 'required'
        ]);

        Role::create([
            'nama_role' => $request->nama_role
        ]);

        return back()->with('success', 'Role berhasil ditambahkan');
    }

    // tambah shift ke role
    public function tambahShift(Request $request, $role_id)
    {
        $request->validate([
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'fee_per_unit' => 'required|numeric'
        ]);

        RoleShift::create([
            'role_id'      => $role_id,
            'jam_mulai'    => $request->jam_mulai,
            'jam_selesai'  => $request->jam_selesai,
            'fee_per_unit' => $request->fee_per_unit,
        ]);

        return back()->with('success', 'Shift berhasil ditambahkan');
    }

    public function deleteShift($id)
    {
        RoleShift::find($id)->delete();
        return back()->with('success', 'Shift berhasil dihapus');
    }

    public function deleteRole($id)
    {
        Role::find($id)->delete();
        return back()->with('success', 'Role berhasil dihapus');
    }
}
