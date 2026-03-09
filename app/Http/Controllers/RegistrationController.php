<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'area' => 'required|string|max:255',
            'has_car' => 'required|boolean',
            'available_seats' => 'nullable|integer|min:1|max:20',
        ], [
            'name.required' => 'الاسم مطلوب',
            'phone.required' => 'رقم الهاتف مطلوب',
            'area.required' => 'المنطقة مطلوبة',
            'has_car.required' => 'يرجى تحديد إذا لديك سيارة',
        ]);

        if ($event->isFull()) {
            return back()->with('error', 'عذراً، الفعالية ممتلئة.');
        }

        $validated['event_id'] = $event->id;

        if (!$validated['has_car']) {
            $validated['available_seats'] = null;
        }

        Registration::create($validated);

        return redirect('/registration/success')->with('event_name', $event->name);
    }

    public function success()
    {
        return view('registration.success');
    }
}
