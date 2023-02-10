<?php

use App\Models\Customer;
// use App\Models\Order;
use App\Models\PaymentTransaction;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\TaxonomyItem;
use App\Models\Topping;
use App\Models\Voucher;

return [
    /*
     *--------------------------------------------------------------------------
     * Pages Language Lines
     *--------------------------------------------------------------------------
     */

    // 'topping' => [
    //     'title_topping' => 'Quản lý toppings',
    //     'list_topping' => 'Danh sách toppings',
    //     'create_topping' => 'Thêm topping',
    //     'edit_topping' => 'Sửa topping',
    //     'edit_price' => 'Chỉnh sửa giá',
    //     'name' => 'Tên topping',
    //     'price' => 'Giá gốc',
    //     'sale_price' => 'Giá bán',
    //     'status' => 'Trạng thái',
    //     'status_option' => [
    //         Topping::STATUS_ACTIVE => 'Bật',
    //         Topping::STATUS_INACTIVE => 'Tắt',
    //     ],
    // ],


    'roles' => [
        'role_name' => 'Tên nhóm quyền',
        'create_role_text' => 'Thêm nhóm quyền',
        'edit_role_text' => 'Sửa nhóm quyền',
        'delete_role_text' => 'Xoá nhóm quyền',
        'delete_role_confirm_text' => 'Có chắc chắn muốn xoá nhóm quyền ?',
        'assign_permission_text' => 'Chỉnh sửa quyền',
    ],

    'permissions' => [
        'roles_dropdown_label' => 'Nhóm quyền',
        'permission_name' => 'Quyền truy cập',
        'save_button_text' => 'Lưu thay đổi',
        'revert_button_text' => 'Không thay đổi',
    ],

    'users' => [
        'title_user' => 'Quản lý nhân viên',
        'title_list' => 'Danh sách nhân viên',
        'name' => 'Tên nhân viên',
        'create_user' => 'Thêm nhân viên',
        'edit_user' => 'Sửa nhân viên',
        'full_name' => 'Tên đầy đủ',
        'email' => 'Email',
        'name_login' => 'Tên đăng nhập',
        'position' => 'Chức vụ',
        'position_list' => 'Nhóm chức vụ',
        'select_position' => 'Chọn chức vụ',
        'user_stores' => 'Chi nhánh',
        'select_user_stores' => 'Chọn chi nhánh',
        'password' => 'Mật khẩu',
        'password_confirmation' => 'Xác nhận mật khẩu',
        'phone' => 'Số điện thoại',
        'birthday' => 'Ngày sinh',
        'address' => 'Địa chỉ',
        'status' => 'Trạng thái',
        'team' => 'Team',
        'select_team' => 'Chọn Team'
    ],

    'customers' => [
        'title_customer' => 'Quản lý khách hàng',
        'list_customer' => 'Danh sách khách hàng',
        'create_customer' => 'Thêm khách hàng',
        'edit_customer' => 'Sửa khách hàng',
        'name' => 'Tên',
        'phone_number' => 'Số điện thoại',
        'email' => 'Email',
        'code' => 'Mã khách hàng',
        'address' => 'Địa chỉ',
        'birthday' => 'Ngày sinh',
        'note' => 'Ghi chú',
        'group_customer' => 'Nhóm khách hàng',
        'point' => 'Số điểm',
        'order_count' => 'Số đơn hàng',
        'status' => 'Trạng thái',
        'status_option' => [
            Customer::STATUS_ACTIVE => 'Bật',
            Customer::STATUS_INACTIVE => 'Tắt',
        ],
    ],

    'apply_leave' => [
        'title' => 'Quản lí nghỉ phép',
        'update' => 'Cập nhập',
        'store' => 'Đăng kí',
        'list_apply' => 'Danh sách đăng kí',
        'my_list_apply_leave' => 'Danh sách nghỉ phép của tôi',
        'list_apply_leave' => 'Danh sách nghỉ phép',
        'create_apply' => 'Tạo đơn',
        'stt' => 'STT',
        'phone' => 'SĐT',
        'address' => 'Địa chỉ',
        'name' => 'Họ & Tên',
        'position' => 'Chức vụ',
        'reason' => 'Lí do nghỉ phép',
        'start_date' => 'Ngày/giờ bắt đầu',
        'end_date' => 'Ngày/giờ kết thúc',
        'status' => 'Trạng thái',
        'action' => 'Thao tác',
        'select_position' => 'Chọn chức vụ',
        'full_phone' => 'Số điện thoại',
        'cand' => "Hủy"
    ],
    'overtime' => [
        'title' => 'Quản lí tăng ca',
        'update' => 'Cập nhập',
        'store' => 'Đăng kí',
        'list_overtime' => 'Danh sách',
        'my_list_overtime' => 'Danh sách tăng ca của tôi',
        'list_overtime' => 'Danh sách tăng ca',
        'create_overtime' => 'Tạo đơn',
        'stt' => 'STT',
        'phone' => 'SĐT',
        'address' => 'Địa chỉ',
        'name' => 'Họ & Tên',
        'position' => 'Chức vụ',
        'work_content' => 'Nội dung công việc',
        'start_date' => 'Ngày/giờ bắt đầu',
        'end_date' => 'Ngày/giờ kết thúc',
        'status' => 'Trạng thái',
        'action' => 'Thao tác',
        'select_position' => 'Chọn chức vụ',
        'full_phone' => 'Số điện thoại'
    ],
    'dashboard' => [
        'all_user' => 'Tất cả nhân viên',
        'apple_leave'=> 'Thống kê nghỉ phép',
        'overtime' => 'Thống kê tăng ca',
        'name' => 'Tên nhân viên',
        'sdt'=>'Số điện thoại',
        'address'=>'Địa chỉ',
        'start_date' => "Ngày/giờ bắt đầu",
        'end_date'=>'Ngày/giờ kết thúc',
        'total'=>'Tổng số giờ nghỉ',
        'total_hour'=>'Tổng số giờ tăng ca',
        'all_roles' => 'Tất cả chức vụ',
    ]
];
