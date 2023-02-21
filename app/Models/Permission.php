<?php

namespace App\Models;

use App\Models\Traits\UsesUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use SoftDeletes, UsesUuid;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Define All permission for role acrions
     *
     * @var string
     */
    const USERS_GROUP = 'users';
    const ROLE_GROUP = 'roles';
    const APPLY_LEAVE_GROUP = 'apply_leaves';
    const OVERTIME_GROUP = 'overtimes';
    const STATISTIC_GROUP = 'statistics';
    const CONFIRMATION_FROM_LEADER = 'confirm_from_leader';
    const CONFIRMATION_FROM_DIRECTOR = 'confirm_from_director';
    /**
     * Define permissip map group with each child permission
     *
     * @var array
     */
    const GROUPS = [
        self::USERS_GROUP => [
            'users.show',
            'users.create',
            'users.edit',
            'users.delete',
        ],
        self::ROLE_GROUP => [
            'roles.show',
            'roles.create',
            'roles.edit',
            'roles.delete',
        ],
        self::APPLY_LEAVE_GROUP => [
            'apply_leaves.show',
            'apply_leaves.create',
            'apply_leaves.edit',
            'apply_leaves.delete',
        ],
        self::OVERTIME_GROUP => [
            'overtimes.show',
            'overtimes.create',
            'overtimes.edit',
            'overtimes.delete',
        ],
        self::STATISTIC_GROUP => [
            'statistic',
        ],
        self::CONFIRMATION_FROM_LEADER => [
            'confirm_apply_leaves_from_leader',
            'refuse_apply_leaves_from_leader',
            'confirm_overtime_from_leader',
            'refuse_overtime_from_leader',
        ],
        self::CONFIRMATION_FROM_DIRECTOR => [
            'confirm_apply_leaves_from_director',
            'refuse_apply_leaves_from_director',
            'confirm_overtime_from_director',
            'refuse_overtime_from_director',
        ],
    ];
}
