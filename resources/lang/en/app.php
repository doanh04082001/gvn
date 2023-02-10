<?php

return [
    /*
     *--------------------------------------------------------------------------
     * Common app Language Lines: en
     *--------------------------------------------------------------------------
     */

    'messages' => [
        'error' => [
            'internal_server' => 'Internal server error.',
            'data_was_invalid' => 'The given data was invalid.',
            'unauthorized' => 'This action is unauthorized.',
            'unauthenticated' => 'This action is unauthenticated.',
            'notfound' => 'Not found.',
            'unknown' => 'Unknown error.',
            'store_not_existed' => 'Store not existed.',
            'user_is_unverified' => 'User is unverified.',
            'user_has_been_blocked' => 'User has been blocked.',
            'order_missing_property' => 'Order missing property.',
            'product_not_existed' => 'Product not existed.',
            'cannot_cancel_order' => 'Không thể hủy đơn hàng!!!',
        ],
        'success' => [
            'add' => 'Added successfully.',
            'create' => 'Created successfully.',
            'modify' => 'modified successfully.',
            'delete' => 'Deleted successfully.',
            'save' => 'Saved successfully.',
            'enable' => 'Enabled successfully.',
            'disable' => 'Disabled successfully.',
        ],
    ],
    'cart' => [
        'province_lower' => 'province',
        'district_lower' => 'district',
        'ward_lower' => 'ward',
        'address_lower' => 'address',
    ],
    'otp' => [
        'message_otp' => 'Your otp: ',
        'otp_verification' => 'Otp verification',
        'type_otp_code' => 'Enter your otp',
        'send' => 'Send',
        'wrong_otp' => 'Invalid Otp.',
        'retry' => 'Resend',
        'otp_fail' => 'Cannot verify the otp.',
        'fail_to_send' => 'Cannot send otp',
        'otp_sent' => 'A otp is sended to your phone.',
    ],
    'register' => [
        'can_not_sign_up' => 'Can not sign up.',
    ],
    'review' => [
        'cannot_review_again' => 'Cannot review again.',
        'review_order_not_complete' => 'You can not rate the order until it is completed.',
    ],
    'cart_errors' => [
        'cart_empty' => 'Cart is empty.',
        'missing_store_id' => 'Cart missing store.',
        'missing_phone' => 'Cart missing phone number.',
        'missing_customer_id' => 'Cart missing customer.',
        'missing_payment_method' => 'Cart missing payment method or payment method has not supported',
        'missing_delivery_type' => 'Cart missing type of delivery.',
        'missing_address' => 'Cart missing address.',
        'voucher_cannot_apply_store' => 'Voucher not existed or can not apply for this store.',
        'voucher_cannot_use' => 'Voucher had expired or could not use.',
        'voucher_not_reached_min_value' => 'Amount has not reached the minimum value.',
        'voucher_use_too_many' => 'Too many voucher usages.',
    ],
    'currency' => [
        'unit' => 'VND',
    ],
    'shipping_service' => [
        'config_missing' => 'Shipping service configuration error.',
        'shipping_order_missing' => 'Shipping order does not exist.',
    ],
    'permissions' => [
        'error_to_change_permission' => 'Changed permissions fail.'
    ]
];
