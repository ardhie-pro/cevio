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

class UserEventController extends Controller
{
    public function show(Event $event)
    {
        $user = auth()->user();

        $kru = $event->kru()
            ->where('user_id', $user->id)
            ->with(['role', 'roleShift'])
            ->firstOrFail();

        return view('user.event-detail', compact('event', 'kru'));
    }
}
