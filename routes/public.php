<?php

use App\Http\Controllers\Public\BookingController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
