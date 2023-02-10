<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingAddress extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'address'
    ];
}
