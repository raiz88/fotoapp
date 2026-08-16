<?php

use App\Http\Controllers\Public\BookingController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/booking/check-availability', [BookingController::class, 'checkAvailability'])->name('booking.check-availability');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::post('/booking/webhook', [BookingController::class, 'webhook'])->name('booking.webhook');
Route::get('/booking/{token}/return', [BookingController::class, 'returnFromGateway'])->name('booking.return');
Route::get('/booking/{token}/invoice', [BookingController::class, 'downloadInvoice'])->name('booking.invoice');
Route::get('/booking/{token}', [BookingController::class, 'show'])->name('booking.show');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
