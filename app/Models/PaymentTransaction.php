<?php

namespace App\Models;

class PaymentTransaction extends BaseModel
{

    const TYPE_ORDER = 'order';
    const TYPE_PACKAGE = 'package';

    const STATUS_FAIL = 0;
    const STATUS_PENDING = 1;
    const STATUS_REQUEST_SENT = 2;
    const STATUS_MONEY_HOLDING = 3;
    const STATUS_SUCCESS = 4;
    const STATUS_ROLLBACK = 5;
    const STATUS_REFUND = 6;

    const RESQUEST_COMMIT = 'commit';
    const RESQUEST_ROLLBACK = 'rollback';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'order_id',
        'code',
        'partner_transaction_id',
        'method',
        'message',
        'amount',
        'status',
        'full_info',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'full_info' => 'array',
    ];

    /**
     * Get the order that owns the payment transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
