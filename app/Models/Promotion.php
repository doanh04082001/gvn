<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promotion extends BaseFileModel
{
    use HasFactory;

    const POSITION_TOP = 'top';
    const POSITION_MIDDLE = 'middle';

    const TYPE_SAME_PRICE = 1;
    const TYPE_PERCENT = 2;

    const IS_APPLIED = 1;
    const IS_NOT_APPLIED = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'discount_value',
        'max_discount_amount',
        'start_at',
        'expire_at',
        'positions',
        'status',
        'description',
        'images',
        'applied',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'images' => 'array',
        'positions' => 'json',
    ];

    /**
     * Default save on disk (from keys of app/config/filesystem.php > disks)
     *
     * @var string
     */
    protected $saveOnDisk = 'public';

    /**
     * Save path file to folder
     *
     * @var string
     */
    protected $fileFolders = [
        'images.square' => 'promotions',
        'images.rectangle' => 'promotions',
        'images.rectangle_2x3' => 'promotions',
    ];

    /**
     * Save path to column name
     *
     * @var array
     */
    protected $fileFields = [
        'images.square',
        'images.rectangle',
        'images.rectangle_2x3',
    ];

    /**
     * The stores that belong to the promotion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }

    /**
     * The products that belong to the promotion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * The products are applying promotion
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function productApplyings()
    {
        return $this->belongsToMany(Product::class, 'product_store');
    }

    /**
     * Caculate price with promotion
     *
     * @param float $originPrice
     * @return float
     */
    public function caculatePrice(float $originPrice = 0.0)
    {
        if ($this->type == self::TYPE_SAME_PRICE) {
            return $this->discount_value;
        }

        $discount = $originPrice * $this->discount_value / 100;
        if ($discount > $this->max_discount_amount) {
            $discount = $this->max_discount_amount;
        }

        return $discount < $originPrice
            ? $originPrice - $discount
            : 0.0;
    }
}
