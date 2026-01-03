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
        // User
        Gate::define('manage-user', fn($authed_user, $user) => in_array($authed_user->role, [RoleEnum::ADMIN]) || $authed_user->id === $user->id);

        // Pelatihan
        Gate::define('manage-pelatihan', fn($authed_user) => in_array($authed_user->role, [RoleEnum::ADMIN]));

        Gate::define('manage-pendaftaran-pelatihan', fn($authed_user) => in_array($authed_user->role, [RoleEnum::ADMIN, RoleEnum::PENGELOLA_PENDAFTARAN]));

        Gate::define('manage-gelombang-pelatihan', fn($authed_user) => in_array($authed_user->role, [RoleEnum::ADMIN, RoleEnum::PENGELOLA_PENDAFTARAN]));

        Gate::define('manage-jadwal-ujian-pelatihan', fn($authed_user) => in_array($authed_user->role, [RoleEnum::ADMIN, RoleEnum::PENGELOLA_PENDAFTARAN]));

        Gate::define('manage-hasil-ujian-pelatihan', fn($authed_user) => in_array($authed_user->role, [RoleEnum::ADMIN, RoleEnum::PENGELOLA_PENDAFTARAN]));
        // Kontrak kerja
        Gate::define('manage-kontrak-kerja', fn($authed_user) => in_array($authed_user->role, [RoleEnum::ADMIN]));

        Gate::define('manage-kontrak-kerja-peserta', fn($authed_user) => in_array($authed_user->role, [RoleEnum::ADMIN]));

        Gate::define('manage-pengajuan-kontrak-kerja', fn($authed_user) => in_array($authed_user->role, [RoleEnum::ADMIN, RoleEnum::PENGELOLA_PENDAFTARAN]));

        // Rekening
        Gate::define('manage-rekening', fn($authed_user) => in_array($authed_user->role, [RoleEnum::ADMIN, RoleEnum::BENDAHARA]));
    }
}
