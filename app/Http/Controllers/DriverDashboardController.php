<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Ride;
use Illuminate\Http\Request;

class DriverDashboardController extends Controller
{
    /**
     * Show driver dashboard via secure token link.
     */
    public function show(string $token)
    {
        $driver = Registration::where('driver_token', $token)
            ->where('has_car', true)
            ->firstOrFail();

        $ride = Ride::where('driver_registration_id', $driver->id)
            ->with([
                'passengers.areaModel',
                'event',
                'transportAxis',
            ])
            ->first();

        return view('driver.dashboard', compact('driver', 'ride'));
    }

    /**
     * Update ride status.
     */
    public function updateStatus(Request $request, string $token)
    {
        $request->validate([
            'status' => 'required|in:pending,ready,on_the_way,completed',
        ]);

        $driver = Registration::where('driver_token', $token)
            ->where('has_car', true)
            ->firstOrFail();

        $ride = Ride::where('driver_registration_id', $driver->id)->firstOrFail();

        $ride->update(['status' => $request->status]);

        $statusLabels = [
            'pending'     => 'في الانتظار',
            'ready'       => 'جاهز للانطلاق',
            'on_the_way'  => 'في الطريق',
            'completed'   => 'اكتملت الرحلة',
        ];

        return back()->with('success', 'تم تحديث الحالة: ' . $statusLabels[$request->status]);
    }
}
