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

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $events = Event::whereHas('kru', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with(['kru' => function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->with(['role', 'roleShift']);
        }])->latest()->get();

        return view('user.dashboard', compact('events'));
    }
}
