<?php

// use App\Models\Order;

return [
    /*
     *--------------------------------------------------------------------------
     * Common app Language Lines: vi
     *--------------------------------------------------------------------------
     */
    'ok_text' => 'Đồng ý',
    'cancel_text' => 'Huỷ',
    'comfirm_title_text' => 'Xác nhận',
    'comfirm_content_text' => 'Hành động cần được xác nhận!',
    'confirm_delete_text' => 'Có đồng ý xoá ?',
    'confirm_delete_hint_text' => 'Không thể lấy lại sau khi xoá!',
    'confirm_important_action_text' => 'Thao tác quan trọng',
    'show_all_text' => 'Tất cả',

    'messages' => [
        'error' => [
            'internal_server' => 'Lỗi không xác định từ máy chủ.',
            'data_was_invalid' => 'Dữ liệu đã nhập không hợp lệ',
            'unauthorized' => 'Không có quyền thực hiện hành động này.',
            'unauthenticated' => 'Cần đăng nhập để thực hiện hành động này.',
            'notfound' => 'Không tìm thấy dữ liệu.',
            'unknown' => 'Lỗi không xác định.',
            'user_is_unverified' => 'Người dùng chưa được xác thực.',
            'user_has_been_blocked' => 'Tài khoản đã bị khoá.',
        ],
        'success' => [
            'add' => 'Thêm thành công!',
            'create' => 'Tạo thành công!',
            'modify' => 'Cập nhật thành công!',
            'delete' => 'Xoá thành công!',
            'save' => 'Lưu thành công!',
            'enable' => 'Kích hoạt thành công!',
            'disable' => 'Vô hiệu hóa thành công!',
        ],
    ],

    'super_admin' => 'Quản trị viên cấp cao',

    'admin' => 'Nhân sự',
    'lead' => 'Leader',
    'staff' => 'Nhân viên',
    'dev' => 'Developer',
    'tester' => 'Tester',
    'marketing' => 'Marketing',
    'hr' => 'Hành chính nhân sự',
    'action' => 'Thao tác',
    'add_button_text' => 'Thêm',
    'save_button_text' => 'Lưu',
    'save_button_text_icon' => '<i class="fas fa-save"></i> LƯU',
    'back_button_text' => '<i class="fas fa-arrow-left"></i> QUAY LẠI',
    'cancel_button_text' => 'Huỷ',
    'save_text' => 'Lưu',
    'change_text' => 'Thay đổi',
    'accept_text' => 'Chấp nhận',
    'cart_errors' => [
        'cart_empty' => 'Không có sản phẩm trong giỏ hàng.',
        'missing_store_id' => 'Chưa chọn nơi đặt.',
        'missing_phone' => 'Chưa có số điện thoại.',
        'missing_customer_id' => 'Người dùng không tồn tại trong giỏ hàng.',
        'missing_payment_method' => 'Chưa họn phương thức thanh toán hoặc phương thức thanh toán không hỗ trợ.',
        'missing_delivery_type' => 'Chưa chọn phương thức giao hàng.',
        'missing_address' => 'Chưa chọn địa chỉ nhận hàng',
        'voucher_cannot_apply_store' => 'Mã khuyến mại không còn tồn tại hoặc không áp dụng cho cửa hàng hiện tại.',
        'voucher_cannot_use' => 'Mã khuyến mại đã hết hạn sử dụng.',
        'voucher_not_reached_min_value' => 'Chưa đạt giá trị tối thiểu để sử dụng khuyến mại.',
        'voucher_use_too_many' => 'Mã khuyến mại quá số lần sử dụng.',
    ],
    'sent' => 'Đã gửi',
    'leader_confirmed' => 'Leader đã xác nhận',
    'success' => 'Thành công',
    'refuse' => "Từ chối",

    'register' => [
        'can_not_sign_up' => 'Không thể đăng ký.',
    ],

    'currency' => [
        'unit' => 'VND',
    ],

    'permissions' => [
        'error_to_change_permission' => 'Lỗi phân quyền.'
    ],
    'login_with_gitlab' => 'Login with GitLab',
    'something_went_wrong' => 'Đã xảy ra sự cố hoặc Bạn đã từ chối ứng dụng'
];
