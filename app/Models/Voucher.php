<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Voucher extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'name',
        'discount_amount',
        'max_apply',
        'min_order_amount',
        'start_at',
        'expire_at',
        'max_discount_amount',
        'description',
        'status',
        'apply_time',
    ];

    const TYPE_PERCENT = 1;
    const TYPE_FIX = 2;

    const APPLY_TIME_ONCE = 1;
    const APPLY_TIME_MANY = 2;

    /**
     * The orders that are applied to the voucher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check voucher can use
     *
     * @return boolean
     */
    public function canUse()
    {
        return $this->isActive() && Carbon::now()->between($this->start_at, $this->expire_at);
    }

    /**
     * Voucher is active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->status = self::STATUS_ACTIVE;
    }

    /**
     * Can apply many times
     *
     * @return boolean
     */
    public function canApplyMany()
    {
        return $this->apply_time = self::APPLY_TIME_ONCE;
    }

    /**
     * Check can apply for store
     *
     * @return boolean
     */
    public function canApplyStore($storeId)
    {
        return $this->stores()->whereId($storeId)->exists();
    }

    /**
     * The store that applied the voucher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }
}
