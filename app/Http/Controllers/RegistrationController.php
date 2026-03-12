<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Area;
use App\Models\Event;
use App\Models\Registration;

class RegistrationController extends Controller
{
    public function store(StoreRegistrationRequest $request, Event $event)
    {
        if ($event->isFull()) {
            return back()->with('error', 'عذراً، الفعالية ممتلئة.');
        }

        $data = $request->validatedWithArea();
        $data['event_id'] = $event->id;

        Registration::create($data);

        return redirect('/registration/success')->with('event_name', $event->name);
    }

    public function success()
    {
        return view('registration.success');
    }
}
