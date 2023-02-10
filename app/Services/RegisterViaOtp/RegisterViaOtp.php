<?php

namespace App\Services\RegisterViaOtp;

use Exception;
use App\Models\Otp;
use App\Jobs\OtpJob;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Exceptions\InternalServerError;
use App\Services\Otp\Contracts\OtpService;
use App\Exceptions\Otps\InvalidOtpException;
use App\Services\Otp\Objects\ValidateObject;
use App\Services\Otp\Objects\CreateOtpObject;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Repositories\Contracts\CustomerRepository;
use App\Exceptions\Otps\OtpCanNotBeResendedException;
use App\Services\RegisterViaOtp\Contracts\RegisterViaOtpService;

/**
 * Class RegisterViaOtp
 *
 * @package App\Services\RegisterViaOtp
 */
class RegisterViaOtp implements RegisterViaOtpService
{
    use DispatchesJobs;

    /**
     * Create a new RegisterViaOtp instance.
     *
     * @return void
     */
    public function __construct(
        CustomerRepository $customerRepository,
        OtpService $otpService
    ) {
        $this->customerRepository = $customerRepository;
        $this->otpService = $otpService;
    }

    /**
     * Register.
     *
     * @param array $registerData
     * @return array
     * @throws InternalServerError
     */
    public function register(array $registerData): array
    {
        DB::beginTransaction();
        try {
            $user = $this->customerRepository->create($registerData);
            $verifyData = $this->buildVerifyData($user);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            throw new InternalServerError(__('app.register.can_not_sign_up'));
        }

        return $verifyData;
    }

    /**
     * Resend Otp.
     *
     * @param array $otpResendData
     * @return array
     * @throws OtpCanNotBeResendedException|InternalServerError
     */
    public function resendOtp(array $otpResendData): array
    {
        if (!$otp = $this->otpService->createOtpResend($otpResendData['customer_id'], $otpResendData['request_id'])) {
            throw new OtpCanNotBeResendedException(__('app.otp.fail_to_send'));
        }

        try {
            $this->dispatch(new OtpJob($otp));
        } catch (Exception $exception) {
            throw new InternalServerError();
        }

        return [
            'request_id' => $otpResendData['request_id'],
            'customer_id' => $otpResendData['customer_id'],
        ];
    }

    /**
     * Validate otp.
     *
     * @param array $ValidateOtpData
     * @return null
     * @throws InvalidOtpException|InternalServerError
     */
    public function optValidate($validateOtpData)
    {
        if (!$this->otpService->validateOtp(
            new ValidateObject(
                $validateOtpData['customer_id'],
                $validateOtpData['request_id'],
                $validateOtpData['otp']
            ))
        ) {
            throw new InvalidOtpException(__('app.otp.wrong_otp'));
        }

        try {
            $customerId = $validateOtpData['customer_id'];

            $this->customerRepository->verify($customerId);
            $this->customerRepository->storeDeviceToken(
                $this->customerRepository->find($customerId),
                $validateOtpData['device_token'] ?? null
            );
        } catch (Exception $exception) {
            throw new InternalServerError(__('app.otp.otp_fail'));
        }
    }

    /**
     * Send otp
     *
     * @param App\Models\Customer $customer
     * @return App\Models\Otp
     */
    private function sendOtp(Customer $customer)
    {
        $otp = $this->otpService->createOtpRecord(new CreateOtpObject(
            $customer->id,
            $customer->phone,
            Otp::OTP_TYPE_REGISTER
        ));

        $this->dispatch(new OtpJob($otp));

        return $otp;
    }

    /**
     * Build verify data
     *
     * @param mixed $phone
     * @return array|void
     */
    public function buildVerifyData(Customer $customer)
    {
        $otp = $this->sendOtp($customer);

        return [
            'request_id' => $otp->id,
            'customer_id' => $otp->customer_id,
        ];
    }

    /**
     * send verify data
     *
     * @param mixed $phone
     * @return array|void
     */
    public function verify($phone)
    {
        try {
            $customer = $this->customerRepository->firstByPhone($phone);
            $verifyData = $this->buildVerifyData($customer);
        } catch (Exception $exception) {
            throw new InternalServerError(__('app.otp.fail_to_send'));
        }

        return $verifyData;
    }
}
