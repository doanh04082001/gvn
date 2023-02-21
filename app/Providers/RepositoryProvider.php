<?php

namespace App\Providers;

use App\Repositories\ApplyLeaveRepositoryEloquent;
use App\Repositories\Contracts\ApplyLeaveRepository;
use App\Repositories\Contracts\CustomerRepository;
use App\Repositories\Contracts\NotificationRepository;
use App\Repositories\Contracts\OvertimeRepository;
use App\Repositories\Contracts\PermissionRepository;
use App\Repositories\Contracts\RoleRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\CustomerRepositoryEloquent;
use App\Repositories\NotificationRepositoryEloquent;
use App\Repositories\OvertimeRepositoryEloquent;
use App\Repositories\PermissionRepositoryEloquent;
use App\Repositories\RoleRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $bindings = $this->loadRepositoryBindings();

        if (!empty($bindings)) {
            foreach ($bindings as $abstract => $concrete) {
                $this->app->bind($abstract, $concrete);
            }
        }
    }

    /**
     * Config binding default of repository
     *
     * @return array
     */
    private function loadRepositoryBindings(): array
    {
        return [
            UserRepository::class => UserRepositoryEloquent::class,
            RoleRepository::class => RoleRepositoryEloquent::class,
            PermissionRepository::class => PermissionRepositoryEloquent::class,
            CustomerRepository::class => CustomerRepositoryEloquent::class,
            NotificationRepository::class => NotificationRepositoryEloquent::class,
            ApplyLeaveRepository::class => ApplyLeaveRepositoryEloquent::class,
            OvertimeRepository::class => OvertimeRepositoryEloquent::class
        ];
    }
}
