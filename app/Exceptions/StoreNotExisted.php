<?php

namespace App\Exceptions;

use App\Http\Responses\ResponseCode;
use Exception;

class StoreNotExisted extends Exception
{
    /**
     * @var int
     */
    public $code = ResponseCode::STORE_NOT_EXISTS;

    public function __construct()
    {
        parent::__construct(__('app.messages.error.store_not_existed'));
    }
}
