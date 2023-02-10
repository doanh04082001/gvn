<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OvertimeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getMethod() == 'PUT'
            ? auth()->user()->canAccessStore($this->store)
            : true;
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
            'work_content' => 'required',
            'start_date' => 'bail|required|after:today',
            'end_date' => 'bail|required|after:today'
        ];
    }
}
