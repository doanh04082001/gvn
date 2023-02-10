<?php

namespace App\Services\Payment\Validator;

use App\Services\Payment\Gateways\Configs\MomoConfig;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class MomoVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'partnerCode' => 'required|string',
            'orderId' => 'required|string',
            'requestId' => [
                'required',
                'string',
                Rule::exists('orders', 'id'),
            ],
            'amount' => 'required',
            'orderInfo' => 'required|string',
            'orderType' => [
                'required',
                'string',
                Rule::in(['momo_wallet']),
            ],
            'transId' => 'required',
            'resultCode' => 'required|integer',
            'message' => 'required|string',
            'payType' => [
                'required',
                'string',
                Rule::in(['web', 'qr']),
            ],
            'extraData' => 'nullable|string',
            'signature' => 'required|string',
        ];
    }

    /**
     *
     * @param Validator $validator
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if (!in_array($this->ip(), MomoConfig::getConfigs(MomoConfig::ACCEPTED_IPS))) {
                $validator->errors()->add('ip', __('app.payment.no_allowed'));
            }
        });
    }
}
