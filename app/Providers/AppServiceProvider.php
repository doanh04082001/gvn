<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // development
        if (!$this->app->environment('production')) {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        $this->loadProviderForAppOnly();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }

    /**
     * Load provider with Admin or API
     *
     * @return void
     */
    private function loadProviderForAppOnly()
    {
        $providers = $this->getProviders();

        if (empty($providers)) {
            return;
        }

        foreach ($providers as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * Load provider app only
     *
     * @return Array
     */
    private function getProviders()
    {
        $appOnlyFor = config('app.only_for');
        $providers = config('providers.all');

        if (!$appOnlyFor) {
            return array_unique(array_merge(
                $providers,
                config('providers.admin'),
                config('providers.api'),
                config('providers.web'),
                config('providers.sale-api')
            ));
        }

        if ($appOnlyFor == ADMIN_RESOURCE) {
            $providers = array_merge($providers, config('providers.admin'));
        }

        if ($appOnlyFor == API_RESOURCE) {
            $providers = array_merge($providers, config('providers.api'));
        }

        if ($appOnlyFor == WEB_RESOURCE) {
            $providers = array_merge($providers, config('providers.web'));
        }

        if ($appOnlyFor == SALE_API_RESOURCE) {
            $providers = array_merge($providers, config('providers.sale-api'));
        }

        return array_unique($providers);
    }
}
