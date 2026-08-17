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

        $design = $request->string('design', 'editorial')->toString();
        $coreMemoryViews = [
            'editorial' => 'public.home-corememory',
            'garden' => 'public.home-corememory-garden',
            'midnight' => 'public.home-corememory-midnight',
        ];

        $view = $brand->code === 'corememory'
            ? ($coreMemoryViews[$design] ?? $coreMemoryViews['editorial'])
            : 'public.home';

        return view($view, ['brand' => $brand, 'packages' => $packages, 'design' => $design]);
    }

    public function gallery(Request $request): View
    {
        /** @var Brand $brand */
        $brand = app(Brand::class);
        $design = $request->string('design', 'editorial')->toString();
        $views = [
            'editorial' => 'public.gallery-corememory-editorial',
            'garden' => 'public.gallery-corememory-garden',
            'midnight' => 'public.gallery-corememory-midnight',
        ];

        $view = $brand->code === 'corememory'
            ? ($views[$design] ?? $views['editorial'])
            : 'public.gallery';

        return view($view, ['brand' => $brand, 'design' => $design]);
    }
}
