<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DriverDashboardController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminRideController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ───
Route::get('/', [EventController::class, 'index'])->name('home');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('events.register');
Route::get('/registration/success', [RegistrationController::class, 'success'])->name('registration.success');

// ─── Driver Dashboard (token-based access) ───
Route::get('/driver/{token}', [DriverDashboardController::class, 'show'])->name('driver.dashboard');
Route::post('/driver/{token}/status', [DriverDashboardController::class, 'updateStatus'])->name('driver.update-status');

// ─── Admin Auth ───
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ─── Admin Panel (protected) ───
Route::middleware(\App\Http\Middleware\AdminAuth::class)->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('events', AdminEventController::class);

    // Legacy assignment routes (kept for backward compat)
    Route::post('/events/{event}/assign-driver', [AdminEventController::class, 'assignDriver'])->name('events.assign-driver');
    Route::post('/events/{event}/unassign-driver', [AdminEventController::class, 'unassignDriver'])->name('events.unassign-driver');
    Route::get('/events/{event}/whatsapp/{driver}', [AdminEventController::class, 'whatsappLink'])->name('events.whatsapp');
    Route::delete('/events/{event}/registrations/{registration}', [AdminEventController::class, 'deleteRegistration'])->name('events.delete-registration');

    // ─── Ride Management ───
    Route::get('/events/{event}/rides', [AdminRideController::class, 'index'])->name('events.rides');
    Route::post('/events/{event}/rides/auto-distribute', [AdminRideController::class, 'autoDistribute'])->name('events.rides.auto-distribute');
    Route::post('/events/{event}/rides/clear-auto', [AdminRideController::class, 'clearAuto'])->name('events.rides.clear-auto');
    Route::post('/events/{event}/rides/add-passenger', [AdminRideController::class, 'addPassenger'])->name('events.rides.add-passenger');
    Route::post('/events/{event}/rides/remove-passenger', [AdminRideController::class, 'removePassenger'])->name('events.rides.remove-passenger');
    Route::post('/events/{event}/rides/move-passenger', [AdminRideController::class, 'movePassenger'])->name('events.rides.move-passenger');
    Route::post('/events/{event}/rides/create-manual', [AdminRideController::class, 'createManualRide'])->name('events.rides.create-manual');
    Route::delete('/events/{event}/rides/{ride}', [AdminRideController::class, 'deleteRide'])->name('events.rides.delete');
});
