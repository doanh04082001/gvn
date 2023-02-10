<?php

namespace App\Services\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Services\Payment\PaymentService;
use App\Services\Payment\Validator\MomoAppConfirmRequest;
use App\Services\Payment\Validator\MomoVerificationRequest;

class WebhookController extends Controller
{
    /**
     *  Constructor.
     *
     * @param PaymentService $paymentService
     */
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     *  Handler Momo Instant-Payment-Notification for WEB pay.
     *
     * @param MomoVerificationRequest $request
     * @return void
     */
    public function verifyMomoWebIPN(MomoVerificationRequest $request)
    {
        return response()->json(
            $this->paymentService->verifyForWeb(
                PaymentMethod::MOMO_METHOD,
                $request->all()
            )
        );
    }

    /**
     *  Handler Momo Instant-Payment-Notification for APP pay.
     *
     * @param MomoAppConfirmRequest $request
     * @return void
     */
    public function verifyMomoAppIPN(MomoAppConfirmRequest $request)
    {
        return response()->json(
            $this->paymentService->verifyForApp(
                PaymentMethod::MOMO_METHOD,
                $request->all()
            )
        );
    }
}
