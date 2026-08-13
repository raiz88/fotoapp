<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        /** @var Brand $brand */
        $brand = app(Brand::class);
        $base = $brand->publicUrl();

        $urls = collect([
            ['loc' => $base.route('home', absolute: false), 'priority' => '1.0'],
            ['loc' => $base.route('packages.index', absolute: false), 'priority' => '0.9'],
            ['loc' => $base.route('gallery', absolute: false), 'priority' => '0.5'],
            ['loc' => $base.route('contact', absolute: false), 'priority' => '0.5'],
        ])->merge(
            $brand->packages()->published()->get()->map(fn ($package) => [
                'loc' => $base.route('packages.show', $package, absolute: false),
                'priority' => '0.8',
            ])
        );

        $xml = view('public.sitemap', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
