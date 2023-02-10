<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
        $userRules = [
            'name' => 'required',
            'user_role' => [
                'required',
                'string',
                Rule::exists('roles', 'id')
                    ->whereNull('deleted_at')
                    ->whereNotIn('name', [Role::SUPER_ADMIN_NAME]),
            ],
            'team' => 'required',
            'phone' => 'nullable|regex:' . PHONE_REGEX,
            'birthday' => 'nullable|date_format:' . DATE_FORMAT_VALIDATION,
            'address' => 'nullable|string',
        ];

        $this->setUserRules($userRules);

        return $userRules;
    }

    /**
     * Set user validation rules
     *
     * @param array &$rules
     * @return void
     */
    private function setUserRules(&$rules)
    {
        if ($this->method() === 'POST') {
            $rules['email'] = 'required|email|unique:users,email' . (isset($this->user->id) ? ',' . $this->user->id : '');
        }

        if ($this->method() === 'POST' || !empty($this->password) || !empty($this->password_confirmation)) {
            $rules['password'] = 'required|string|min:8|max:255';
            $rules['password_confirmation'] = 'required|string|min:8|max:255|same:password';
        }
    }
}
