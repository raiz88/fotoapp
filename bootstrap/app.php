<?php

use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Middleware\ResolveBrand;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'brand' => ResolveBrand::class,
            'active' => EnsureUserIsActive::class,
        ]);

        // withRouting(web: ...) automatically wraps routes/web.php in the base
        // 'web' group *before* our own nested groups run — so its
        // SubstituteBindings would resolve route-model-bindings (e.g. Package
        // {package:slug}) before BrandScope is ever switched on, letting a
        // cross-brand slug leak through. Strip it from the base group and add
        // it back explicitly, in the right position, in each nested group below.
        $middleware->web(remove: [SubstituteBindings::class]);

        $middleware->group('public', [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            PreventRequestForgery::class,
            ResolveBrand::class,
            SubstituteBindings::class,
        ]);

        $middleware->group('admin_web', [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            PreventRequestForgery::class,
            SubstituteBindings::class,
        ]);

        // ToyyibPay calls this server-to-server with no CSRF token to give.
        $middleware->validateCsrfTokens(except: ['booking/webhook']);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
