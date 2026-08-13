<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['public'])
    ->group(base_path('routes/public.php'));

Route::domain(config('branding.admin_domain'))
    ->middleware(['admin_web'])
    ->group(base_path('routes/admin.php'));
