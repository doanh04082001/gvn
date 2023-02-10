<?php

namespace App\Services\RegisterViaOtp\Contracts;

use App\Http\Requests\Api\OtpRequest;
use App\Models\Otp;

/**
 * Interface RegisterViaOptService
 *
 * @package App\Services\RegisterViaOtp\Contracts
 */
interface RegisterViaOtpService
{
    /**
     * Register.
     *
     * @param array $registerData
     * @return array
     */
    public function register(array $registerData): array;

    /**
     * Resend Otp.
     *
     * @param array $otpResendData
     * @return array
     */
    public function resendOtp(array $otpResendData): array;

    /**
     * Validate otp.
     *
     * @param array $otpData
     * @return boolean
     */
    public function optValidate(OtpRequest $otpData);
}
