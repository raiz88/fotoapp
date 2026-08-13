<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        /** @var Brand $brand */
        $brand = app(Brand::class);

        $packages = $brand->packages()
            ->published()
            ->orderBy('sort_order')
            ->with('items')
            ->get();

        return view('public.home', ['brand' => $brand, 'packages' => $packages]);
    }

    public function gallery(): View
    {
        return view('public.gallery');
    }
}
