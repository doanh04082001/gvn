<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\SlugHandle;
use App\Models\BaseModel;

class StaticPage extends BaseModel
{
    use HasFactory, SlugHandle;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'content',
        'order',
        'status',
    ];
}
