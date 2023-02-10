<?php

namespace App\Models;

use App\Models\BaseModel;

class PaymentMethod extends BaseModel
{
    const CASH_METHOD = 'cash';
    const ATM_METHOD = 'atm';
    const VISA_METHOD = 'visa';
    const MOMO_METHOD = 'momo';
    const AIRPAY_METHOD = 'airpay';
    const DEFAULT_METHOD = self::CASH_METHOD;

    const CLIENT_WEBSITE = 'website';
    const CLIENT_MOBILE = 'mobile';
    
    const PAYMENT_METHOD_ALLOWS = [
        self::CASH_METHOD,
        self::ATM_METHOD,
        self::VISA_METHOD,
        self::MOMO_METHOD,
        self::AIRPAY_METHOD,
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'config',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'config' => 'array',
    ];
}
