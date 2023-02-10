<?php

namespace App\Exceptions;

use App\Http\Responses\ResponseCode;
use Exception;

class ProductNotExisted extends Exception
{
    /**
     * @var int
     */
    public $code = ResponseCode::PRODUCT_NOT_EXISTS;
}
