<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalEvents = Event::count();
        $activeEvents = Event::active()->count();
        $upcomingEvents = Event::upcoming()->count();
        $recentEvents = Event::latest('event_date')
            ->withCount('registrations')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalEvents',
            'activeEvents',
            'upcomingEvents',
            'recentEvents'
        ));
    }
}
