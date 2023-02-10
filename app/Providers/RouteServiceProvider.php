<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $appOnlyFor = config('app.only_for');

            if (!$appOnlyFor || $appOnlyFor == ADMIN_RESOURCE) {
                $this->mapAdminRoutes();
            }

            if (!$appOnlyFor || $appOnlyFor == API_RESOURCE) {
                $this->mapApiRoutes();
            }

            if (!$appOnlyFor || $appOnlyFor == WEB_RESOURCE) {
                $this->mapWebRoutes();
            }

            if (!$appOnlyFor || $appOnlyFor == SALE_API_RESOURCE) {
                $this->mapSaleApiRoutes();
            }

        });
    }

    /**
     * Define the "Admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    private function mapAdminRoutes()
    {
        $this->handleDomainForResource(ADMIN_RESOURCE)
            ->as('admin.')
            ->namespace("$this->namespace\\Admin")
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "Api" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    private function mapApiRoutes()
    {
        $this->handleDomainForResource(API_RESOURCE)
            ->middleware('api')
            ->namespace("$this->namespace\\Api")
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "Web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    private function mapWebRoutes()
    {
        $this->middleware('web')
            ->namespace("$this->namespace\\Web")
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "Sale Api" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    private function mapSaleApiRoutes()
    {
        $this->handleDomainForResource(SALE_API_RESOURCE)
            ->middleware('sale-api')
            ->namespace("$this->namespace\\SaleApi")
            ->group(base_path('routes/sale-api.php'));
    }

    /**
     * Handle subdomain or uri for resource
     *
     * @param string $resource
     * @return \Illuminate\Routing\RouteRegistrar
     */
    private function handleDomainForResource(string $resource)
    {
        $route = Route::middleware($resource);

        if (!env('APP_USE_SUB_DOMAIN', false)) {
            return $route->prefix($resource);
        }

        $domain = domain();

        return $route->domain("{$resource}.{$domain}");
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
