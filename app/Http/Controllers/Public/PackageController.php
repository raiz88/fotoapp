<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Package;
use Illuminate\Contracts\View\View;

class PackageController extends Controller
{
    public function index(): View
    {
        /** @var Brand $brand */
        $brand = app(Brand::class);

        $packages = $brand->packages()
            ->published()
            ->orderBy('sort_order')
            ->with('items', 'addons')
            ->get();

        return view('public.packages.index', ['brand' => $brand, 'packages' => $packages]);
    }

    public function show(Package $package): View
    {
        abort_unless($package->is_active && $package->published_at, 404);

        $package->load('items', 'addons');

        return view('public.packages.show', ['brand' => $package->brand, 'package' => $package]);
    }
}
