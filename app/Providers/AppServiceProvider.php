<?php

namespace App\Providers;

use App\Enums\User\RoleEnum;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
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
        // Set locale carbon
        Carbon::setLocale(config('app.locale'));

        // Gate policies
        Gate::define('manage-user', fn($authed_user, $user) => in_array($authed_user->role, [RoleEnum::ADMIN]) || $authed_user->id === $user->id);
        Gate::define('manage-kontrak-kerja', fn($authed_user) => in_array($authed_user->role, [RoleEnum::ADMIN]));
        Gate::define('manage-pelatihan', fn($authed_user) => in_array($authed_user->role, [RoleEnum::ADMIN]));
    }
}
