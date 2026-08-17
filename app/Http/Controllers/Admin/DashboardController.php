<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Brand;
use App\Models\Package;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $brands = Brand::where('is_active', true)->withCount(['packages', 'addons'])->orderBy('name')->get();

        return view('admin.dashboard', [
            'brands' => $brands,
            'totalPackages' => Package::count(),
            'totalAddons' => Addon::count(),
        ]);
    }
}
