<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
        $uniqueRule = Rule::unique('roles', 'name')->whereNull('deleted_at');

        if ($this->method() == 'PUT' && $this->role) {
            $uniqueRule->whereNot('id', $this->role->id);
        }

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'not_in:' . Role::SUPER_ADMIN_NAME,
                $uniqueRule,
            ],
        ];
    }
}
