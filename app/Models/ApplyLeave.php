<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ApplyLeave.
 *
 * @package namespace App\Models;
 */
class ApplyLeave extends Model implements Transformable
{
    use TransformableTrait;
    const STATUS_SEND = 0;
    const STATUS_CONFIRM_LEAD = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_FAIL = 3;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'email', 'phone', 'address', 'reason', 'start_date', 'end_date', 'status', 'position'];

    public function users(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
