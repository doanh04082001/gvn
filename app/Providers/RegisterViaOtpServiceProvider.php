<?php

namespace App\Providers;

use App\Services\RegisterViaOtp\Contracts\RegisterViaOtpService;
use App\Services\RegisterViaOtp\RegisterViaOtp;
use Illuminate\Support\ServiceProvider;

class RegisterViaOtpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RegisterViaOtpService::class, function ($app) {
            return $app->make(RegisterViaOtp::class);
        });
    }
}
