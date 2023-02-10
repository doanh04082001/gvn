<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'note',
        'store_id'
    ];

    /**
     * Get the store that owns the table.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
