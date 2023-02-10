<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AcceptToChangePermission;
use App\Models\Permission;

class RolePermissionRequest extends FormRequest
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
        $rules = [];
        foreach (Permission::GROUPS as $group => $permissions) {
            $rules[$group] = 'required|array|size:2';
            $rules["{$group}.hasGroupPermission"] = 'required|boolean';
            $rules["{$group}.permissions"] = 'required|size:' . count($permissions);
            $rules["{$group}.permissions.*"] = [
                'required',
                'boolean',
                new AcceptToChangePermission($group, $permissions)
            ];
        }

        return $rules;
    }
}
