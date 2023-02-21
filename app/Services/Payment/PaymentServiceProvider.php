<?php

namespace App\Services\Payment;

// use App\Models\PaymentMethod;
use App\Services\Payment\Contracts\PaymentService as PaymentServiceContract;
use App\Services\Payment\Gateways\Momo;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Service register
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PaymentServiceContract::class, PaymentService::class);
        // $this->app->singleton(PaymentMethod::MOMO_METHOD, Momo::class);
    }

    /**
     * Bootstrap service
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        $this->registerHelpers();
    }

    /**
     * Register helpers file
     */
    public function registerHelpers()
    {
        if (file_exists($file = __DIR__ . '/Supports/helpers.php')) {
            require $file;
        }
    }
}
