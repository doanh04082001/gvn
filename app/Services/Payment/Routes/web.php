<?php

/*
 *--------------------------------------------------------------------------
 * Payment Routes
 *--------------------------------------------------------------------------
 */

use App\Services\Payment\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'webhooks'], function () {
    Route::post('/momo/ipn/web', [WebhookController::class, 'verifyMomoWebIPN'])->name('webhooks.momo.web');
    Route::post('/momo/ipn/app', [WebhookController::class, 'verifyMomoAppIPN'])->name('webhooks.momo.app');
});
