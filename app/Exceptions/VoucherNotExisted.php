<?php

namespace App\Exceptions;

use App\Http\Responses\ResponseCode;
use Exception;

class VoucherNotExisted extends Exception
{
    /**
     * @var int
     */
    public $code = ResponseCode::VOUCHER_NOT_EXISTS;

    public function __construct()
    {
        parent::__construct(__('app.messages.error.voucher_not_existed'));
    }
}
