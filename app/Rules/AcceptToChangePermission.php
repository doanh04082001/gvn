<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AcceptToChangePermission implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $group, array $permissions)
    {
        $this->group = $group;
        $this->permissions = $permissions;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  bool  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return in_array($attribute, array_map(
            function ($permission) {
                return "{$this->group}.permissions.{$permission}";
            }, $this->permissions
        ));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.accept_to_change_permission');
    }
}
