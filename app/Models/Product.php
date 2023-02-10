<?php

namespace App\Models;

use App\Models\Traits\OnlyStore;
use App\Models\Traits\SlugHandle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Product extends BaseFileModel
{
    use HasFactory, SlugHandle, OnlyStore;

    const MAXIMUM_PAGINATION = 20;
    const LIMIT_ITEM_LIST = 5;

    const MORPH_KEY = 'product';

    const IS_FEATURED = 1;
    const IS_NOT_FEATURED = 0;

    const IS_COMBO = 1;
    const IS_NOT_COMBO = 0;

    const IS_ONLINE = 1;
    const IS_OFFLINE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'sku',
        'category_id',
        'unit_id',
        'image',
        'cost',
        'description',
        'order',
        'parent_id',
        'rating',
        'rating_count',
        'is_combo',
        'is_online',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order');
        });
    }

    /**
     * Get the products for the category.
     * Save path file to folder
     *
     * @var string
     */
    protected $fileFolders = ['image' => 'products'];

    /**
     * Save path to column name
     *
     * @var array
     */
    protected $fileFields = ['image'];

    /**
     * Default save on disk (from keys of app/config/filesystem.php > disks)
     *
     * @var string
     */
    protected $saveOnDisk = 'public';

    /**
     * Get the promotions that applies to the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function promotions()
    {
        return $this->belongsToMany(Promotion::class);
    }

    /**
     * Get the varients for the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variants()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Get the product for the variant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get the product for the variant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productWithTrashed()
    {
        return $this->belongsTo(self::class, 'parent_id')->withTrashed();
    }

    /**
     * Get full name attribute
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->parent_id && !empty($this->product)
            ? $this->product->name . ' - ' . $this->name
            : $this->name;
    }

    /**
     * The toppings that belong to the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function toppings()
    {
        return $this->belongsToMany(Topping::class)->where('status', Topping::STATUS_ACTIVE);
    }

    /**
     * The combo that belong to the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function combos()
    {
        return $this
            ->belongsToMany(self::class, 'combo_product', 'combo_id', 'product_id')
            ->withPivot(['quantity']);
    }

    /**
     * Get the category that applies to the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(TaxonomyItem::class, 'category_id');
    }

    /**
     * Get the category that applies to the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(TaxonomyItem::class, 'unit_id');
    }

    /**
     * Get all customers who like the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function customers()
    {
        return $this->morphToMany(Customer::class, 'favoriteable')->where('status', Customer::STATUS_ACTIVE);
    }

    /**
     * Get the stores that applies to the product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stores()
    {
        return $this->belongsToMany(Store::class)
            ->wherePivot('status', BaseModel::STATUS_ACTIVE)
            ->withPivot([
                'quantity',
                'price',
                'sale_price',
                'promotion_id',
                'promotion_price',
                'sold',
                'featured',
            ]);
    }

    /**
     * Get all of the product's review.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * Get all of the order items that are product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get product's apply price with store pivot
     *
     * @param Pivot $storePivot
     * @return float
     */
    public function applyPrice(Pivot $storePivot)
    {
        return isset($storePivot->promotion_price) && $storePivot->sale_price > $storePivot->promotion_price
            ? $storePivot->promotion_price
            : $storePivot->sale_price;
    }

    /**
     * Product has variants
     *
     * @return bool
     */
    public function hasVariant()
    {
        return $this->variants()->exists();
    }

    /**
     * Check product is saling at store
     *
     * @param string $storeId
     * @return boolean
     */
    public function canBuyAtStore($storeId)
    {
        return $this->stores()
            ->wherePivot('status', BaseModel::STATUS_ACTIVE)
            ->whereId($storeId)
            ->exists();
    }

    /**
     * Check any variants of product is saling at store
     *
     * @param string $storeId
     * @return boolean
     */
    public function canBuyAnyVariantAtStore($storeId)
    {
        return $this->variants->contains(function ($variant) use ($storeId) {
            return $variant->stores()
                ->wherePivot('status', BaseModel::STATUS_ACTIVE)
                ->whereId($storeId)
                ->exists();
        });
    }

    /**
     * Set slug
     *
     * @return void
     */
    public function slugable()
    {
        if ($parent = $this->product) {
            return "{$parent->name}-{$this->name}";
        }

        return $this->name;
    }
}
