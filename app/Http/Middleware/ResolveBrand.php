<?php

namespace App\Http\Middleware;

use App\Models\Brand;
use App\Scopes\BrandScope;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resolves the current request's Brand from its hostname and binds it into
 * the container for the rest of the request. Also switches on BrandScope
 * so brand-owned models are automatically filtered to this brand — public
 * and portal routes can never leak another brand's data.
 */
class ResolveBrand
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        if (app()->environment('local') && $request->query('brand')) {
            $request->session()->put('dev_brand', $request->query('brand'));
        }

        $devCode = app()->environment('local') ? $request->session()->get('dev_brand') : null;
        $lookupHost = $devCode ? $devCode.'.localhost' : $host;

        $brand = Brand::where('is_active', true)
            ->where(fn ($q) => $q->where('domain', $lookupHost)->orWhere('dev_domain', $lookupHost))
            ->first();

        if (! $brand) {
            abort(404);
        }

        app()->instance(Brand::class, $brand);
        View::share('brand', $brand);
        app()->setLocale('ms');

        BrandScope::$enabled = true;

        try {
            return $next($request);
        } finally {
            BrandScope::$enabled = false;
        }
    }
}
