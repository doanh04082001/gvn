<?php

return [
    /*
     *--------------------------------------------------------------------------
     * notification Language Lines
     *--------------------------------------------------------------------------
     */

    "orders" => [
        "new_order" => [
            "title" => "Có một đơn hàng mới.",
            "body" => "Mã đơn hàng: :code",
        ],
        "cancel_order" => [
            "title" => "Đơn hàng đã bị huỷ.",
            "body" => "Mã đơn hàng: :code \nCửa hàng: :store_name"
        ],
        "update_status" => [
            "title" => "Cập nhật trạng thái đơn hàng.",
            "body" => "Mã đơn hàng: :code \nTrạng thái: :status"
        ],
        "status_options" => [
            "0" => "Hủy",
            "1" => "Chờ xử lý",
            "2" => "Đang xử lý",
            "3" => "Đang giao",
            "4" => "Hoàn thành"
        ]
    ],

    "shippings" => [
        "accepted" => [
            "title" => "Tài xế đã nhận đơn giao hàng.",
            "body" => "Mã đơn hàng: :code \nCửa hàng: :store_name",
        ],
        "completed" => [
            "title" => "Giao hàng thành công.",
            "body" => "Mã đơn hàng: :code \nCửa hàng: :store_name"
        ],
        "cancelled" => [
            "title" => "Đơn giao hàng đã bị huỷ.",
            "body" => "Mã đơn hàng: :code \nCửa hàng: :store_name"
        ]
    ]
];
