<script>
    const BASE_ADMIN_URL = `{{ adminUrl('') }}`
    const ADDED_SUCCESS = `{{ __('app.messages.success.add') }}`
    const CREATED_SUCCESS = `{{ __('app.messages.success.create') }}`
    const MODIFIED_SUCCESS = `{{ __('app.messages.success.modify') }}`
    const DELETED_SUCCESS = `{{ __('app.messages.success.delete') }}`
    const SAVE_SUCCESS = `{{ __('app.messages.success.save') }}`

    const INTERNAL_SERVER_ERROR_MESSAGE = `{{ __('app.messages.error.internal_server') }}`
    const UNAUTHORIZED_ERROR_MESSAGE = `{{ __('app.messages.error.unauthorized') }}`
    const NOTFOUND_ERROR_MESSAGE = `{{ __('app.messages.error.notfound') }}`
    const UNAUTHENTICATED_ERROR_MESSAGE = `{{ __('app.messages.error.unauthenticated') }}`
    const DATA_WAS_INVALID_ERROR_MESSAGE = `{{ __('app.messages.error.data_was_invalid') }}`
    const UNKNOWN_ERROR_MESSAGE = `{{ __('app.messages.error.unknown') }}`

    const OK_TEXT = `{{ __('app.ok_text') }}`
    const CANCEL_TEXT = `{{ __('app.cancel_text') }}`
    const CONFIRM_TITLE_TEXT = `{{ __('app.comfirm_title_text') }}`
    const CONFIRM_CONTENT_TEXT = `{{ __('app.comfirm_content_text') }}`
    const CONFIRM_DELETE_TEXT = `{{ __('app.confirm_delete_text') }}`
    const CONFIRM_DELETE_HINT_TEXT = `{{ __('app.confirm_delete_hint_text') }}`
    const CONFIRM_IMPORTANT_ACTION_TEXT = `{{ __('app.confirm_important_action_text') }}`
    // const CONFIRM_CHANGE_ORDER_STATUS_HINT_TEXT = `{{ __('app.confirm_change_order_status_hint_text') }}`

    //default images
    const IMAGE_PATH = `{{ asset('assets/images') }}`;
    const DEFAULT_SQUARE_IMAGE = `{{ asset('assets/images/default-square.jpg') }}`;
    const DEFAULT_SUPPORT_AVATAR = `{{ asset('assets/images/default-support-avatar.png') }}`;
    const CHANGE_TEXT = `{{ __('app.change_text') }}`
    const DEFAULT_RECTANGLE_IMAGE = `{{ asset('assets/images/default-rectangle.jpg') }}`;
    const DEFAULT_RECTANGLE_2x3_IMAGE = `{{ asset('assets/images/default-rectangle-2x3.jpg') }}`;
    const CHANGE_PRICE_STORE = '{{ __('pages.product.change_price_store') }}';

    // Shipping service modal
    // const SHIPPING_SERVICE_MODAL_TITLE = `{{ __('pages.order_detail.select_shipping_service') }}`;
    const AHAMOVE_SHIPPING_SERVICE = @json(App\Models\Setting::AHAMOVE_SHIPPING_METHOD);
    const GET_SHIPPING_SERVICE_URL = `{{ route('admin.setting.shipping.active-shippings') }}`;


    // Statistic
    const CONFIRM_SYNCHRONIZE_TEXT = `{{ __('pages.revenue_statistic.confirm_synchronize_text') }}`

    // Daterangepicker
    const DATERANGEPICKER_LOCALE = {
        applyLabel: `{{ __('app.daterangepicker.locale.applyLabel') }}`,
        cancelLabel: `{{ __('app.daterangepicker.locale.cancelLabel') }}`,
        customRangeLabel: `{{ __('app.daterangepicker.locale.customRangeLabel') }}`
    }
    const DATERANGEPICKER_CUSTOM_RANGE = {
        today: `{{ __('app.daterangepicker.custom_range.today') }}`,
        yesterday: `{{ __('app.daterangepicker.custom_range.yesterday') }}`,
        last_seven_days: `{{ __('app.daterangepicker.custom_range.last_seven_days') }}`,
        last_thirty_day: `{{ __('app.daterangepicker.custom_range.last_thirty_day') }}`,
        this_month: `{{ __('app.daterangepicker.custom_range.this_month') }}`,
        last_month: `{{ __('app.daterangepicker.custom_range.last_month') }}`,
    }
</script>
