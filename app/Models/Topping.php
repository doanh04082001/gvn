<?php

namespace App\Models;

use App\Models\Traits\OnlyStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topping extends BaseModel
{
    use HasFactory, OnlyStore;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    protected $fillable = [
        'name',
        'price',
        'sale_price',
        'status',
    ];

    /**
     * The products that belong to the topping.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * The stores that belong to the topping.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function storesWithInactive()
    {
        return $this->belongsToMany(Store::class);
    }

    /**
     * The order items that belong to the topping.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orderItems()
    {
        return $this->belongsToMany(OrderItem::class);
    }

    /**
     * The stores that belong to the topping.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stores()
    {
        return $this->belongsToMany(Store::class)
            ->wherePivot('status', BaseModel::STATUS_ACTIVE)
            ->withPivot(
                [
                    'quantity',
                    'price',
                    'sale_price',
                ]
            );
    }
}
