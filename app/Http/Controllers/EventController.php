<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TransportAxis;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::upcoming()->withCount('registrations')->get();

        return view('home', compact('events'));
    }

    public function show(Event $event)
    {
        $event->loadCount('registrations');

        $axes = TransportAxis::active()
            ->with(['areas' => fn ($q) => $q->active()->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        return view('events.show', compact('event', 'axes'));
    }
}
