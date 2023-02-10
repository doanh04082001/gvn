<?php

namespace App\Models;

use App\Models\Traits\JWTAuthentication;
use App\Models\Traits\UsesCode;
use App\Services\Firebase\SyncsWithFirebase;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends BaseAuthentication implements JWTSubject
{
    use SyncsWithFirebase, UsesCode, JWTAuthentication;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const NOTIFICATION_STATUS_INACTIVE = 0;
    const NOTIFICATION_STATUS_ACTIVE = 1;

    const GENDER_FEMALE = 0;
    const GENDER_MALE = 1;
    const GENDER_NA = 2;

    const ALLOWED_GENDER = [
        self::GENDER_FEMALE,
        self::GENDER_MALE,
        self::GENDER_NA,
    ];

    const LIMIT_ITEMS = 10;

    const MORPH_KEY = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'email',
        'password',
        'avatar',
        'status',
        'phone',
        'address',
        'birthday',
        'gender',
        'note',
        'setting',
        'verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'setting' => 'json',
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
    protected $fileFolders = ['avatar' => 'customers'];

    /**
     * Save path to column name
     *
     * @var array
     */
    protected $fileFields = ['avatar'];

    /**
     * Specific fields to sync to firebase
     *
     * @var array
     */
    protected $firebaseSyncFields = [
        'id',
        'name',
        'avatar',
    ];

    /**
     * Get all of the products that are liked by this customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function products()
    {
        return $this->morphedByMany(Product::class, 'favoriteable')
            ->where('status', Product::STATUS_ACTIVE);
    }

    /**
     * Get all of the stores that are liked by this customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function stores()
    {
        return $this->morphedByMany(Store::class, 'favoriteable');
    }

    /**
     * Get the reviews for the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the orders for the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Count the number of uses
     *
     * @param string $voucherId
     * @return int
     */
    public function countNumberOfUses(string $voucherId)
    {
        return $this->orders()->where('voucher_id', $voucherId)->count();
    }

    /**
     * Specifies the user's FCM token
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return ($this->setting['notification_state'] ?? null)
            ? parent::routeNotificationForFcm()
            : [];
    }

    /**
     * Customer Favorited store.
     *
     * @param string $storeId
     * @return bool
     */
    public function isFavoriteStore($storeId)
    {
        return $this->stores()->where('id', $storeId)->exists();
    }

    /**
     * Get last shipping address
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastShippingAddress()
    {
        return $this->hasone(ShippingAddress::class)->orderByDesc('updated_at');
    }
}
