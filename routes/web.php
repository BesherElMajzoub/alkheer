<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminEventController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ───
Route::get('/', [EventController::class, 'index'])->name('home');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('events.register');
Route::get('/registration/success', [RegistrationController::class, 'success'])->name('registration.success');

// ─── Admin Auth ───
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ─── Admin Panel (protected) ───
Route::middleware(\App\Http\Middleware\AdminAuth::class)->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('events', AdminEventController::class);

    Route::post('/events/{event}/assign-driver', [AdminEventController::class, 'assignDriver'])->name('events.assign-driver');
    Route::post('/events/{event}/unassign-driver', [AdminEventController::class, 'unassignDriver'])->name('events.unassign-driver');
    Route::get('/events/{event}/whatsapp/{driver}', [AdminEventController::class, 'whatsappLink'])->name('events.whatsapp');
    Route::delete('/events/{event}/registrations/{registration}', [AdminEventController::class, 'deleteRegistration'])->name('events.delete-registration');
});
