<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Brand;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        /** @var Brand $brand */
        $brand = app(Brand::class);

        $packages = $brand->packages()
            ->published()
            ->orderBy('sort_order')
            ->get();

        return view('public.home', [
            'brand' => $brand,
            'packages' => $packages,
            'timeSlots' => Booking::SLOTS,
        ]);
    }
}
