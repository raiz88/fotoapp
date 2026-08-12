<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return redirect()->route('bookings.index');
});

Route::resource('bookings', BookingController::class)->only(['index', 'create', 'store', 'destroy']);
Route::get('bookings/calendar', [BookingController::class, 'calendar'])->name('bookings.calendar');
