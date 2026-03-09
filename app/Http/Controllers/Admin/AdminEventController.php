<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;

class AdminEventController extends Controller
{
    public function index()
    {
        $events = Event::latest('event_date')
            ->withCount('registrations')
            ->get();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'max_attendees' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Event::create($validated);

        return redirect('/admin/events')->with('success', 'تم إنشاء الفعالية بنجاح');
    }

    public function show(Request $request, Event $event)
    {
        $filter = $request->query('filter', 'all');

        $query = $event->registrations();

        if ($filter === 'drivers') {
            $query->drivers();
        } elseif ($filter === 'needs_ride') {
            $query->needsRide();
        }

        $registrations = $query->orderBy('created_at', 'desc')->get();

        $drivers = $event->registrations()->drivers()->withCount('passengers')->get();
        $unassigned = $event->registrations()->unassigned()->get();

        return view('admin.events.show', compact('event', 'registrations', 'filter', 'drivers', 'unassigned'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'max_attendees' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $event->update($validated);

        return redirect('/admin/events')->with('success', 'تم تحديث الفعالية بنجاح');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect('/admin/events')->with('success', 'تم حذف الفعالية بنجاح');
    }

    public function assignDriver(Request $request, Event $event)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'driver_id' => 'required|exists:registrations,id',
        ]);

        $registration = Registration::where('id', $request->registration_id)
            ->where('event_id', $event->id)
            ->firstOrFail();

        $driver = Registration::where('id', $request->driver_id)
            ->where('event_id', $event->id)
            ->where('has_car', true)
            ->firstOrFail();

        // Check if driver has available seats
        $currentPassengers = $driver->passengers()->count();
        if ($driver->available_seats && $currentPassengers >= $driver->available_seats) {
            return back()->with('error', 'لا توجد مقاعد متاحة لدى هذا السائق');
        }

        $registration->update(['assigned_driver_id' => $driver->id]);

        return back()->with('success', 'تم تعيين السائق بنجاح');
    }

    public function unassignDriver(Request $request, Event $event)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
        ]);

        $registration = Registration::where('id', $request->registration_id)
            ->where('event_id', $event->id)
            ->firstOrFail();

        $registration->update(['assigned_driver_id' => null]);

        return back()->with('success', 'تم إلغاء تعيين السائق');
    }

    public function whatsappLink(Event $event, Registration $driver)
    {
        if (!$driver->has_car || $driver->event_id !== $event->id) {
            abort(404);
        }

        $passengers = $driver->passengers()->get();
        $message = $this->generateWhatsAppMessage($event, $driver, $passengers);
        $phone = $driver->formatted_phone;
        $url = "https://wa.me/{$phone}?text=" . urlencode($message);

        return redirect($url);
    }

    private function generateWhatsAppMessage(Event $event, Registration $driver, $passengers): string
    {
        $message = "السلام عليكم\n";
        $message .= "بارك الله فيك على المساعدة في التوصيل.\n\n";
        $message .= "فعالية: {$event->name}\n\n";

        if ($passengers->isEmpty()) {
            $message .= "لم يتم تعيين طلاب لك بعد.\n";
        } else {
            $message .= "الطلاب الذين ستقوم بتوصيلهم:\n\n";
            foreach ($passengers as $index => $passenger) {
                $num = $index + 1;
                $message .= "{$num}. {$passenger->name} - {$passenger->area} - {$passenger->phone}\n";
            }
        }

        $message .= "\nجزاك الله خيراً.";

        return $message;
    }

    public function deleteRegistration(Event $event, Registration $registration)
    {
        if ($registration->event_id !== $event->id) {
            abort(404);
        }

        // Unassign any passengers assigned to this driver
        if ($registration->has_car) {
            Registration::where('assigned_driver_id', $registration->id)
                ->update(['assigned_driver_id' => null]);
        }

        $registration->delete();

        return back()->with('success', 'تم حذف التسجيل بنجاح');
    }
}
