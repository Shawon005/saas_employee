<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('manage-system', fn ($user) => $user->isSystemAdmin());
        Gate::define('manage-users', fn ($user) => $user->hasRole('super_admin'));
        Gate::define('manage-payroll', fn ($user) => $user->hasRole(['super_admin', 'hr_manager']));
        Gate::define('scan-attendance', fn ($user) => $user->hasRole(['super_admin', 'supervisor']));
    }
}
