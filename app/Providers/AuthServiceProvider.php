<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (isAdmin()) {
            $this->bootWithAdmin();
        }
    }

    /**
     * Register any authentication / authorization services for admin guard
     *
     * @return void
     */
    private function bootWithAdmin()
    {
        ResetPassword::createUrlUsing(function ($user, string $token) {
            return route('admin.password.reset', ['token' => $token]);
        });

        // Implicitly grant Super Admin role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function (User $user, $ability) {
            return $user->hasRole(Role::SUPER_ADMIN_NAME) ? true : null;
        });
    }
}
