<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|max:255',
            'phone' => 'required|string|regex:' . STORE_PHONE_REGEX,
            'address' => 'required|max:255',
            'latitude' => ['regex:' . LATITUDE_REGEX, 'nullable'],
            'longitude' => ['regex:' . LONGITUDE_REGEX, 'nullable'],
        ];
    }
}
