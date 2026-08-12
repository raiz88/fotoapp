<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('dashboard', [BookingController::class, 'dashboard'])->name('dashboard');
Route::resource('bookings', BookingController::class)->only(['index', 'create', 'store', 'destroy']);
Route::get('bookings/calendar', [BookingController::class, 'calendar'])->name('bookings.calendar');
