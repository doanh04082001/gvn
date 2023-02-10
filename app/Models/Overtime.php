<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Overtime.
 *
 * @package namespace App\Models;
 */
class Overtime extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'email', 'phone', 'address', 'work_content', 'start_date', 'end_date', 'status', 'position'];
}
