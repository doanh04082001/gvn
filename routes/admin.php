<?php

/*
 *--------------------------------------------------------------------------
 * Web Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register web routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * contains the "web" middleware group. Now create something great!
 *
 */


Auth::routes([
    'register' => false,
    'verify' => false,
]);
Route::get('gitlab/redirect', [App\Http\Controllers\Admin\Auth\LoginController::class, 'provider'])->name('login.provider');
Route::get('gitlab/callback', [App\Http\Controllers\Admin\Auth\LoginController::class, 'handleCallback'])->name('login.callback');

Route::middleware('auth:admin')->group(function () {
    Route::get('/', 'DashboardController@index')->name('base');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/dashboard/apply_leave-datatable', 'DashboardController@getApplyLeaveDatatable')->name('get.apply_leave.datatable');
    Route::get('/dashboard/processing-datatable', 'DashboardController@getProcessingOrderDatatable')->name('get.processing.order.datatable');
    Route::get('/dashboard/bestseller/chart', 'DashboardController@getBarChartData')->name('get.barchart.data');
    Route::get('/dashboard/statistical', 'DashboardController@getStatistical')->name('get.statistical.data');

    // Store topping
    Route::patch('stores/{store}/toppings/{topping}/status', 'StoreToppingController@changeStatus')
        ->name('stores.toppings.changeStatus')
        ->middleware('permission:toppings.edit');

    Route::put('stores/toppings', 'StoreToppingController@updateMultiStoreTopping')
        ->name('stores.toppings.updateMultiStoreTopping')
        ->middleware('permission:toppings.edit');

    Route::get('stores/toppings', 'StoreToppingController@getDatatable')
        ->name('stores.toppings.getDatatable')
        ->middleware('permission:toppings.show');

    Route::patch('stores/toppings', 'StoreToppingController@update')
        ->name('stores.toppings.update')
        ->middleware('permission:toppings.edit');

    // Store Product
    Route::patch('stores/{store}/products/{product}/featured', 'StoreProductController@changeFeatured')
        ->name('stores.products.changeFeatured')
        ->middleware('permission:products.edit');

    Route::patch('stores/{store}/products/{product}/status', 'StoreProductController@changeStatus')
        ->name('stores.products.changeStatus')
        ->middleware('permission:products.edit');

    Route::put('stores/products/updates', 'StoreProductController@updateMultiStoreProduct')
        ->name('stores.products.updates')
        ->middleware('permission:products.edit');

    Route::get('stores/products', 'StoreProductController@getDatatable')
        ->name('stores.products.getDatatable')
        ->middleware('permission:products.show');

    Route::patch('stores/products', 'StoreProductController@update')
        ->name('stores.products.update')
        ->middleware('permission:products.edit');

    // Store
    Route::resource('stores', 'StoreController')
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->middleware([
            'index' => 'permission:stores.show',
            'create' => 'permission:stores.create',
            'store' => 'permission:stores.create',
            'edit' => 'permission:stores.edit',
            'update' => 'permission:stores.edit',
            'destroy' => 'permission:stores.delete',
        ]);

    // Apply Leave
    Route::post('apply-leaves/{id}/update-status', 'ApplyLeaveController@updateStatus')->name('updateStatus');
    Route::post('apply-leaves/{id}/update-status-fail', 'ApplyLeaveController@updateStatusFail')->name('updateStatusFail');
    Route::resource('apply-leaves', 'ApplyLeaveController')
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->middleware([
            'index' => 'permission:apply_leaves.show',
            'create' => 'permission:apply_leaves.create',
            'store' => 'permission:apply_leaves.create',
            'edit' => 'permission:apply_leaves.edit',
            'update' => 'permission:apply_leaves.edit',
            'destroy' => 'permission:apply_leaves.delete',
        ]);

    // Overtime
    Route::post('overtime/{id}/update-status', 'OvertimeController@updateStatus')->name('updateStatusOvertime');
    Route::post('overtime/{id}/update-status-fail', 'OvertimeController@updateStatusFail')->name('updateStatusFailOvertime');
    Route::resource('overtime', 'OvertimeController')
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->middleware([
            'index' => 'permission:overtimes.show',
            'create' => 'permission:overtimes.create',
            'store' => 'permission:overtimes.create',
            'edit' => 'permission:overtimes.edit',
            'update' => 'permission:overtimes.edit',
            'destroy' => 'permission:overtimes.delete',
        ]);


    // Product
    Route::patch('products/{product}/sync-to-stores', 'ProductController@syncToStores')
        ->name('products.syncToStores')
        ->middleware('permission:products.edit');
    Route::resource('products', 'ProductController')
        ->only(['index', 'datatable', 'create', 'store', 'edit', 'update', 'destroy'])
        ->middleware([
            'index' => 'permission:products.show',
            'datatable' => 'permission:products.show',
            'create' => 'permission:products.create',
            'store' => 'permission:products.create',
            'edit' => 'permission:products.edit',
            'update' => 'permission:products.edit',
            'destroy' => 'permission:products.delete',
        ]);

    // Voucher
    Route::patch('vouchers/{voucher}/change-status', 'VoucherController@changeStatus')
        ->name('vouchers.changeStatus')
        ->middleware('permission:vouchers.update');
    Route::get('vouchers/{voucher}/apply', 'VoucherController@showStores')
        ->name('vouchers.showStores')
        ->middleware('permission:vouchers.edit');
    Route::post('vouchers/{voucher}/apply/{store}', 'VoucherController@applyVoucher')
        ->name('vouchers.apply')
        ->middleware('permission:vouchers.edit');
    Route::resource('vouchers', 'VoucherController')
        ->only(['index', 'datatable', 'create', 'store', 'edit', 'update', 'destroy'])
        ->middleware([
            'index' => 'permission:vouchers.show',
            'datatable' => 'permission:vouchers.show',
            'create' => 'permission:vouchers.create',
            'store' => 'permission:vouchers.create',
            'edit' => 'permission:vouchers.edit',
            'update' => 'permission:vouchers.edit',
            'destroy' => 'permission:vouchers.delete',
        ]);

    // Promotion
    Route::patch('promotions/{promotion}/change-status', 'PromotionController@changeStatus')
        ->name('promotions.changeStatus')
        ->middleware('permission:promotions.update');
    Route::resource('promotions', 'PromotionController')
        ->only(['index', 'datatable', 'create', 'store', 'edit', 'update', 'destroy'])
        ->middleware([
            'index' => 'permission:promotions.show',
            'datatable' => 'permission:promotions.show',
            'create' => 'permission:promotions.create',
            'store' => 'permission:promotions.create',
            'edit' => 'permission:promotions.edit',
            'update' => 'permission:promotions.edit',
            'destroy' => 'permission:promotions.delete',
        ]);

    // Topping
    Route::patch('toppings/{topping}/change-status', 'ToppingController@changeStatus')
        ->name('toppings.changeStatus')
        ->middleware('permission:toppings.edit');
    Route::resource('toppings', 'ToppingController')
        ->only(['index', 'datatable', 'store', 'update', 'destroy'])
        ->middleware([
            'index' => 'permission:toppings.show',
            'datatable' => 'permission:toppings.show',
            'store' => 'permission:toppings.create',
            'update' => 'permission:toppings.edit',
            'destroy' => 'permission:toppings.delete',
        ]);

    // Role
    Route::resource('roles', 'RoleController')
        ->only(['index', 'store', 'update', 'destroy'])
        ->middleware([
            'index' => 'permission:roles.show',
            'store' => 'permission:roles.create',
            'update' => 'permission:roles.edit',
            'destroy' => 'permission:roles.delete',
        ]);

    // Nested Role & permissions
    Route::resource('roles.permissions', 'RolePermissionController')
        ->only(['index', 'store'])
        ->middleware([
            'index' => 'permission:roles.show',
            'store' => 'permission:roles.edit',
        ]);
    Route::get('roles-permissions/redirect', 'RolePermissionController@redirect')
        ->name('roles.permissions.redirect')
        ->middleware('permission:roles.show');

    // Taxonomy-item
    Route::resource('/taxonomy-items', 'TaxonomyItemController')
        ->only(['index', 'datatable', 'store', 'update', 'destroy'])
        ->middleware([
            'index' => 'permission:taxonomy-items.show',
            'datatable' => 'permission:taxonomy-items.show',
            'store' => 'permission:taxonomy-items.store',
            'update' => 'permission:taxonomy-items.update',
            'destroy' => 'permission:taxonomy-items.delete',
        ]);
    Route::put('/taxonomy-items/{id}/status', 'TaxonomyItemController@updateStatus')
        ->middleware(['status' => 'permission:taxonomy-items.update']);

    // reviews
    Route::resource('/reviews', 'ReviewController')
        ->only(['index', 'datatable'])
        ->middleware([
            'index' => 'permission:reviews.show',
        ]);
    Route::get('/orders/{order}/products/reviews', 'ReviewController@getOrderProductReviews')->name('orders.products.reviews.get');

    //Faq
    Route::resource('/faq', 'FaqController')
        ->only(['index', 'datatable', 'create', 'edit', 'store', 'update', 'destroy'])
        ->middleware([
            'index' => 'permission:faq.show',
            'datatable' => 'permission:faq.show',
            'create' => 'permission:faq.create',
            'edit' => 'permission:faq.edit',
            'store' => 'permission:faq.create',
            'update' => 'permission:faq.edit',
            'destroy' => 'permission:faq.delete',
        ]);

    // Static page
    Route::resource('/static-pages', 'StaticPageController')
        ->only(['index', 'datatable', 'create', 'edit', 'store', 'update', 'destroy'])
        ->middleware([
            'index' => 'permission:static-pages.show',
            'datatable' => 'permission:static-pages.show',
            'create' => 'permission:static-pages.create',
            'edit' => 'permission:static-pages.edit',
            'store' => 'permission:static-pages.create',
            'update' => 'permission:static-pages.edit',
            'destroy' => 'permission:static-pages.delete',
        ]);

    // User
    Route::resource('/users', 'UserController')
        ->only(['index', 'datatable', 'create', 'store', 'edit', 'update', 'destroy'])
        ->middleware([
            'index' => 'permission:users.show',
            'datatable' => 'permission:users.show',
            'create' => 'permission:users.create',
            'store' => 'permission:users.create',
            'edit' => 'permission:users.edit',
            'update' => 'permission:users.edit',
            'destroy' => 'permission:users.delete',
        ]);

    // Customer
    Route::resource('customers', 'CustomerController')
        ->only(['index', 'datatable', 'create', 'store', 'edit', 'update', 'destroy'])
        ->middleware([
            'index' => 'permission:customers.show',
            'datatable' => 'permission:customers.show',
            'create' => 'permission:customers.create',
            'store' => 'permission:customers.create',
            'edit' => 'permission:customers.edit',
            'update' => 'permission:customers.edit',
            'destroy' => 'permission:customers.delete',
        ]);

    // Chat Support
    Route::group(
        ['prefix' => 'support', 'as' => 'support.', 'middleware' => ['permission:chat-support.show']],
        function () {
            Route::get('/', 'SupportController@index')->name('index');
            Route::get('/firebase-token', 'SupportController@getFirebaseToken')->name('getFirebaseToken');
        }
    );

    // Order
    Route::resource('/orders', 'OrderController')
        ->only(['index', 'datatable'])
        ->middleware([
            'index' => 'permission:orders.show',
            'datatable' => 'permission:orders.show',
        ]);
    Route::get('/orders/{order}', 'OrderController@show')
        ->middleware('permission:orders.show')
        ->name('orders.show');
    Route::get('/orders/{order}/order-items', 'OrderController@getOrderItemDatatable')
        ->middleware('permission:orders.show')
        ->name('orders.order-items');
    Route::patch('/orders/{order}/status', 'OrderController@updateStatus')
        ->middleware('permission:orders.edit')
        ->name('orders.status');
    Route::put('/orders/{order}/shipping-service', 'OrderController@updateShippingService')
        ->middleware('permission:orders.edit')
        ->name('orders.shippingService');

    // Setting momo payment
    Route::get('payment-methods/momo', 'PaymentMethodController@editMomo')
        ->name('payment-methods.momo.edit')
        ->middleware('permission:payment-methods.momo.edit');
    Route::put('payment-methods/momo', 'PaymentMethodController@updateMomo')
        ->name('payment-methods.momo.update')
        ->middleware('permission:payment-methods.momo.edit');

    // Setting SEO
    Route::resource('meta-data', 'MetaDatumController')
        ->only(['index', 'datatable', 'create', 'store', 'edit', 'update', 'destroy'])
        ->middleware([
            'index' => 'permission:meta-data.show',
            'datatable' => 'permission:meta-data.show',
            'create' => 'permission:meta-data.create',
            'store' => 'permission:meta-data.create',
            'edit' => 'permission:meta-data.edit',
            'update' => 'permission:meta-data.edit',
            'destroy' => 'permission:meta-data.delete',
        ]);

    // Tables
    Route::resource('/tables', 'TableController')
        ->only(['index', 'datatable', 'store', 'update', 'destroy'])
        ->middleware([
            'index' => 'permission:tables.show',
            'datatable' => 'permission:tables.show',
            'store' => 'permission:tables.create',
            'update' => 'permission:tables.edit',
            'destroy' => 'permission:tables.delete',
        ]);

    // Setting
    Route::group(['prefix' => '/setting'], function () {
        // Setting contact
        Route::get('contact', 'SettingContactController@index')
            ->name('setting.contact.index')
            ->middleware('permission:settings.setting-contact');
        Route::put('contact', 'SettingContactController@update')
            ->name('settings.contact')
            ->middleware('permission:settings.setting-contact');

        // Setting shipping
        Route::resource('shipping', 'ShippingController')
            ->only(['index', 'update'])
            ->middleware([
                'index' => 'permission:settings.shipping',
                'update' => 'permission:settings.shipping',
            ]);
        Route::get('active-shippings', 'ShippingController@getActiveShippings')
            ->name('setting.shipping.active-shippings')
            ->middleware('permission:settings.shipping');
    });

    // Notifications
    Route::get('/notifications', 'NotificationController@index')
        ->name('notifications.index');
    Route::put('/notifications/mark-as-read', 'NotificationController@markAsReadAll')->name('notifications.mark-as-read-all');
    Route::patch('/notifications/{notification}/mark-as-read', 'NotificationController@markAsRead')
        ->name('notifications.mark-as-read');

    // Statistics
    Route::group(
        [
            'prefix' => 'statistics',
            'as' => 'statistic.',
            'middleware' => ['permission:statistics.revenue']
        ],
        function () {
            Route::get('/revenue', 'RevenueStatisticController@index')
                ->name('revenue.index');
            Route::get('/revenue/fetch', 'RevenueStatisticController@fetch')
                ->name('revenue.fetch');
            Route::get('/revenue/synchronize', 'RevenueStatisticController@synchronize')
                ->name('revenue.synchronize');
        }
    );
});
