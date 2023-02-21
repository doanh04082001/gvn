<?php

namespace App\Http\Requests\Admin;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ApplyLeaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => 'bail|required|string|regex:' . STORE_PHONE_REGEX,
            'reason'=>'required',
            'start_date' => 'bail|required|after_or_equal:today|before_or_equal:end_date',
            'end_date' => 'bail|required|after_or_equal:start_date'
        ];
    }
}
