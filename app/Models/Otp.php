<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Otp
 *
 * @package App\Models
 */
class Otp extends BaseModel
{
    use HasFactory;

    const OTP_STATUS_NEW = 'new';

    const OTP_STATUS_USED = 'used';

    const OTP_TYPE_REGISTER = 'sign_up';

    const OTP_TYPE_FORGOT_PASSWORD = 'forgot_password';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'phone',
        'type',
        'otp',
        'retry',
        'status'
    ];

}
