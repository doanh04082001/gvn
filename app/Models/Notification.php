<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use SoftDeletes;

    /**
     * @var int
     */
    const TYPE_NEW_ORDER = 1;

    /**
     * @var int
     */
    const TYPE_UPDATE_STATUS_ORDER = 2;

    /**
     * @var int
     */
    const TYPE_CANCEL_ORDER = 3;

    /**
     * @var int
     */
    const TYPE_SHIPPING_ACCEPTED = 4;

    /**
     * @var int
     */
    const TYPE_SHIPPING_COMPLETED = 5;

    /**
     * @var int
     */
    const TYPE_SHIPPING_CANCELLED = 6;

    /**
     * @var array
     */
    const ORDER_TYPES = [
        self::TYPE_NEW_ORDER,
        self::TYPE_UPDATE_STATUS_ORDER,
        self::TYPE_CANCEL_ORDER,
    ];

    /**
     * @var int
     */
    const LIMIT_ADMIN_ITEMS = 15;

    /**
     * @var int
     */
    const LIMIT_WEB_ITEMS = 6;

    /**
     * @var int
     */
    const LIMIT_DROPDOWN_WEB_ITEMS = 5;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'deleted_at',
        'updated_at',
    ];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
