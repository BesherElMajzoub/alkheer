<?php

namespace App\Http\Controllers;

use App\Models\Event;

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

        return view('events.show', compact('event'));
    }
}
