<?php

namespace App\Http\Responses;

/**
 * =========================================
 * ResponseCode interface
 * Define code to write on body response
 * =========================================
 */

interface ResponseCode
{
    /************************************************/
    /* 2xxx Success code                            */
    /************************************************/
    const SUCCESS_CODE = 2000;

    /************************************************/
    /* 4xxx Permission code                         */
    /************************************************/
    const BAD_REQUEST = 4000;
    const UNAUTHENTICATED = 4001;
    const PERMISSION_DENIED = 4003;
    const NOT_FOUND = 4004;
    const METHOD_NOT_ALLOW = 4005;

    /************************************************/
    /* 5xxx Server code                             */
    /************************************************/
    const HTTP_INTERNAL_SERVER_ERROR = 5000;

    /************************************************/
    /* 1xxx Error code                              */
    /************************************************/
    const ERROR_CODE = 1000;
    const EMAIL_EXISTED = 1001;
    const PRODUCT_NOT_EXISTS = 1002;
    const AVATAR_NOT_EXISTS = 1003;
    const PAYMENT_METHOD_NOT_ALLOW = 1004;
    const STORE_NOT_EXISTS = 1005;
    const VARIANT_NOT_EXISTS = 1006;
    const TOPPING_NOT_EXISTS = 1007;
    const VOUCHER_NOT_EXISTS = 1008;
    const VOUCHER_CAN_NOT_USE = 1009;
    const VOUCHER_NOT_REACHED_MIN_VALUE = 1010;
    const VOUCHER_IS_OVERUSED = 1011;
    const ORDER_MISSING_PROPERTY = 1012;
    const ORDER_IS_EMPTY = 1013;
    const PROVINCE_NOT_EXISTS = 1014;
    const DISTRICT_NOT_EXISTS = 1015;
    const WARD_NOT_EXISTS = 1016;
    const PHONE_EXISTED = 1017;
    const OTP_INVALID = 1018;
    const OTP_CAN_NOT_BE_RESENDED = 1019;
    const CANNOT_REVIEW_AGAIN = 1020;
    const ADDRESS_VERSION_JSON_FILE_NOT_EXISTS = 1021;
    const VARIANT_REQUIRED_FOR_PRODUCT = 1023;
    const VOUCHER_CAN_NOT_APPLY_STORE = 1024;
    const CUSTOMER_UNVERIFIED = 1025;
    const CUSTOMER_BLOCKED = 1026;
    const MOMO_REQUEST_FAIL = 1027;
    const CUSTOMER_NOT_EXISTS = 1028;
    const PHONE_NOT_EXISTS = 1029;
    const REVIEW_ORDER_NOT_COMPLETE = 1030;
    const SHIPPING_SERVICE_REQUEST_FAIL = 1031;
    const PASSWORD_INCORRECT = 1032;
    const CANNOT_CANCEL_ORDER = 1033;
    const DELIVERY_TYPE_UNSUPPORTED = 1034;
    const ORDER_PROCESSED = 1035;
    const MISSING_SHIPPING_CONFIG = 1036;
    const SHIPPING_CREATED = 1037;
    const ORDER_MISSING_SHIPPING = 1038;
    const SHIPPING_NOT_EXISTED = 1039;
    const ORDER_STATUS_NOT_ALLOW = 1040;
    const ORDER_PAID = 1041;
    const MOMO_SIGNATURE_NOT_ACCEPTED = 1042;
    const HANDLER_MOMO_DATA_FAIL = 1043;
    const PAYMENT_TRANSACTION_STATUS_CONFLICT = 1044;
    const OUT_OF_WORKING_TIME = 1045;
}
