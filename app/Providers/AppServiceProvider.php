<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('view-profit', fn (User $user) => $user->role === User::ROLE_OWNER);
        Gate::define('manage-packages', fn (User $user) => in_array($user->role, [User::ROLE_OWNER, User::ROLE_ADMIN], true));
        Gate::define('manage-users', fn (User $user) => $user->role === User::ROLE_OWNER);
    }
}
