<?php

namespace App\Http\Controllers\Traits;

use App\Exceptions\UserAccess\UserBlockException;
use App\Exceptions\UserAccess\UserUnverifiedException;
use App\Http\Requests\Api\OtpResendRequest;
use App\Http\Requests\Api\OtpReverifyRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\Customer;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

trait Register
{
    /**
     * Register.
     *
     * @bodyParam password_confirmation string required Customer's password confirmation. Example: abc123456
     *
     * @responseFile docs/api/v1/auth/register/register.2000.json
     * @responseFile status=422 docs/api/v1/auth/register/register.1000.json
     * @responseFile status=422 docs/api/v1/auth/register/register.1001.json
     * @responseFile status=422 docs/api/v1/auth/register/register.1017.json
     * @responseFile status=500 docs/api/v1/errors/500.json
     *
     * @param RegisterRequest $registerRequest
     * @return JsonResponse
     */
    public function register(RegisterRequest $registerRequest): JsonResponse
    {
        return $this->responseJsonSuccess(
            $this->registerViaOtpService
                ->register($registerRequest->data())
        );
    }

    /**
     * Resend OTP.
     *
     * @responseFile docs/api/v1/auth/resend-otp/resendOtp.2000.json
     * @responseFile status=422 docs/api/v1/auth/resend-otp/resendOtp.1000.json
     * @responseFile status=422 docs/api/v1/auth/resend-otp/resendOtp.1019.json
     * @responseFile status=500 docs/api/v1/errors/500.json
     *
     * @param OtpResendRequest $otpResendRequest
     * @return JsonResponse
     */
    public function resendOtp(OtpResendRequest $otpResendRequest): JsonResponse
    {
        return $this->responseJsonSuccess(
            $this->registerViaOtpService
                ->resendOtp($otpResendRequest->validated())
        );
    }

    /**
     * Reverify OTP.
     *
     * Verifing when login a unverified account
     *
     * @responseFile docs/api/v1/auth/reverify-otp/reverify.2000.json
     * @responseFile status=401 docs/api/v1/errors/401.json
     * @responseFile status=403 docs/api/v1/errors/1026.json
     * @responseFile status=422 docs/api/v1/auth/reverify-otp/reverify.1000.json
     * @responseFile status=500 docs/api/v1/errors/500.json
     *
     * @param  mixed $otpVerifyRequest
     * @return JsonResponse|void
     */
    public function reverify(OtpReverifyRequest $otpReverifyRequest)
    {
        $this->checkActive($otpReverifyRequest->only(['phone', 'password']));

        if (!$this->customerRepository->hasVerified($otpReverifyRequest->phone)) {
            return $this->responseJsonSuccess(
                $this->registerViaOtpService
                    ->verify($otpReverifyRequest->phone)
            );
        }
    }

    /**
     * Checking if customer is verified
     *
     * @param mixed $phone
     * @throws UserUnverifiedException
     */
    private function checkVerified($phone)
    {
        if (!$this->customerRepository->hasVerified($phone)) {
            throw new UserUnverifiedException();
        }
    }

    /**
     * Checking if customer is not blocked
     *
     * @param  array $credentials
     * @throws mixed
     */
    private function checkActive(array $credentials)
    {
        if (!auth()->validate($credentials)) {
            throw new AuthenticationException();
        }

        $credentials['status'] = Customer::STATUS_ACTIVE;
        if (!auth()->validate($credentials)) {
            throw new UserBlockException();
        }
    }
}
