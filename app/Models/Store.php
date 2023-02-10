<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends BaseModel
{
    use HasFactory;

    const MORPH_KEY = 'store';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'address',
        'latitude',
        'longitude',
        'rating',
        'rating_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'latitude' => 'double',
        'longitude' => 'double',
    ];

    /**
     * Get all customers who like the store.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function customers()
    {
        return $this->morphToMany(Customer::class, 'favoriteable')->where('status', Customer::STATUS_ACTIVE);
    }

    /**
     * The users that belong to the store.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get all of the store's review.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * The promotions that belong to the store.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function promotions()
    {
        return $this->belongsToMany(Promotion::class)->where('status', Promotion::STATUS_ACTIVE);
    }

    /**
     * The vouchers that are applied to the store.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class)->where('status', Voucher::STATUS_ACTIVE);
    }

    /**
     * The products that belong to the store.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->whereIn('products.is_online', !isSaleApi() ? [Product::IS_ONLINE] : [Product::IS_ONLINE, Product::IS_OFFLINE])
            ->wherePivot('status', BaseModel::STATUS_ACTIVE)
            ->whereNull('parent_id')
            ->withPivot([
                'quantity',
                'price',
                'sale_price',
                'promotion_price',
                'sold',
                'featured'
            ]);
    }

    /**
     * The toppings that belong to the store.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function toppings()
    {
        return $this->belongsToMany(Topping::class)->active();
    }

    /**
     * The toppings that belong to the store with inactive.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function toppingWithInactive()
    {
        return $this->belongsToMany(Topping::class);
    }

    /**
     * The all products that belong to the store
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function allProducts()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Get the tables for the store.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tables()
    {
        return $this->hasMany(Table::class);
    }
}
