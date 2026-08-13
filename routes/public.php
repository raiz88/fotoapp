<?php

use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PackageController;
use App\Http\Controllers\Public\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pakej', [PackageController::class, 'index'])->name('packages.index');
Route::get('/pakej/{package:slug}', [PackageController::class, 'show'])->name('packages.show');
Route::get('/galeri', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/hubungi', [ContactController::class, 'show'])->name('contact');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
