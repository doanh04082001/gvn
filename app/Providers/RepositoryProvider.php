<?php

namespace App\Providers;

use App\Repositories\ApplyLeaveRepositoryEloquent;
use App\Repositories\Contracts\ApplyLeaveRepository;
use App\Repositories\Contracts\CustomerRepository;
// use App\Repositories\Contracts\DistrictRepository;
// use App\Repositories\Contracts\FaqRepository;
// use App\Repositories\Contracts\MetaDatumRepository;
use App\Repositories\Contracts\NotificationRepository;
// use App\Repositories\Contracts\OrderRepository;
// use App\Repositories\Contracts\OrderStatisticRepository;
// use App\Repositories\Contracts\OtpRepository;
use App\Repositories\Contracts\OvertimeRepository;
// use App\Repositories\Contracts\PaymentMethodRepository;
// use App\Repositories\Contracts\PaymentTransactionRepository;
use App\Repositories\Contracts\PermissionRepository;
// use App\Repositories\Contracts\ProductRepository;
// use App\Repositories\Contracts\ProductStatisticViewRepository;
// use App\Repositories\Contracts\PromotionRepository;
// use App\Repositories\Contracts\ProvinceRepository;
// use App\Repositories\Contracts\ReviewRepository;
use App\Repositories\Contracts\RoleRepository;
// use App\Repositories\Contracts\SettingRepository;
// use App\Repositories\Contracts\ShippingAddressRepository;
// use App\Repositories\Contracts\StaticPageRepository;
use App\Repositories\Contracts\StoreRepository;
// use App\Repositories\Contracts\TableRepository;
// use App\Repositories\Contracts\TaxonomyItemRepository;
// use App\Repositories\Contracts\TaxonomyRepository;
// use App\Repositories\Contracts\ToppingRepository;
use App\Repositories\Contracts\UserRepository;
// use App\Repositories\Contracts\VariantRepository;
// use App\Repositories\Contracts\VoucherRepository;
// use App\Repositories\Contracts\WardRepository;
use App\Repositories\CustomerRepositoryEloquent;
// use App\Repositories\DistrictRepositoryEloquent;
// use App\Repositories\FaqRepositoryEloquent;
// use App\Repositories\MetaDatumRepositoryEloquent;
use App\Repositories\NotificationRepositoryEloquent;
// use App\Repositories\OrderRepositoryEloquent;
// use App\Repositories\OrderStatisticRepositoryEloquent;
// use App\Repositories\OtpRepositoryEloquent;
use App\Repositories\OvertimeRepositoryEloquent;
// use App\Repositories\PaymentMethodRepositoryEloquent;
// use App\Repositories\PaymentTransactionRepositoryEloquent;
use App\Repositories\PermissionRepositoryEloquent;
// use App\Repositories\ProductRepositoryEloquent;
// use App\Repositories\ProductStatisticViewRepositoryEloquent;
// use App\Repositories\PromotionRepositoryEloquent;
// use App\Repositories\ProvinceRepositoryEloquent;
// use App\Repositories\ReviewRepositoryEloquent;
use App\Repositories\RoleRepositoryEloquent;
// use App\Repositories\SettingRepositoryEloquent;
// use App\Repositories\ShippingAddressRepositoryEloquent;
// use App\Repositories\StaticPageRepositoryEloquent;
use App\Repositories\StoreRepositoryEloquent;
// use App\Repositories\TableRepositoryEloquent;
// use App\Repositories\TaxonomyItemRepositoryEloquent;
// use App\Repositories\TaxonomyRepositoryEloquent;
// use App\Repositories\ToppingRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
// use App\Repositories\VariantRepositoryEloquent;
// use App\Repositories\VoucherRepositoryEloquent;
// use App\Repositories\WardRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $bindings = $this->loadRepositoryBindings();

        if (!empty($bindings)) {
            foreach ($bindings as $abstract => $concrete) {
                $this->app->bind($abstract, $concrete);
            }
        }
    }

    /**
     * Config binding default of repository
     *
     * @return array
     */
    private function loadRepositoryBindings(): array
    {
        return [
            UserRepository::class => UserRepositoryEloquent::class,
            // PromotionRepository::class => PromotionRepositoryEloquent::class,
            // ProductRepository::class => ProductRepositoryEloquent::class,
            StoreRepository::class => StoreRepositoryEloquent::class,
            RoleRepository::class => RoleRepositoryEloquent::class,
            // TaxonomyItemRepository::class => TaxonomyItemRepositoryEloquent::class,
            PermissionRepository::class => PermissionRepositoryEloquent::class,
            // VoucherRepository::class => VoucherRepositoryEloquent::class,
            // TaxonomyRepository::class => TaxonomyRepositoryEloquent::class,
            // FaqRepository::class => FaqRepositoryEloquent::class,
            // StaticPageRepository::class => StaticPageRepositoryEloquent::class,
            // PaymentMethodRepository::class => PaymentMethodRepositoryEloquent::class,
            CustomerRepository::class => CustomerRepositoryEloquent::class,
            // ToppingRepository::class => ToppingRepositoryEloquent::class,
            // VariantRepository::class => VariantRepositoryEloquent::class,
            // OrderRepository::class => OrderRepositoryEloquent::class,
            // SettingRepository::class => SettingRepositoryEloquent::class,
            // ShippingAddressRepository::class => ShippingAddressRepositoryEloquent::class,
            // ProvinceRepository::class => ProvinceRepositoryEloquent::class,
            // DistrictRepository::class => DistrictRepositoryEloquent::class,
            // WardRepository::class => WardRepositoryEloquent::class,
            // OtpRepository::class => OtpRepositoryEloquent::class,
            // PaymentTransactionRepository::class => PaymentTransactionRepositoryEloquent::class,
            // ReviewRepository::class => ReviewRepositoryEloquent::class,
            // MetaDatumRepository::class => MetaDatumRepositoryEloquent::class,
            // TableRepository::class => TableRepositoryEloquent::class,
            NotificationRepository::class => NotificationRepositoryEloquent::class,
            // OrderStatisticRepository::class => OrderStatisticRepositoryEloquent::class,
            // ProductStatisticViewRepository::class => ProductStatisticViewRepositoryEloquent::class,

            ApplyLeaveRepository::class => ApplyLeaveRepositoryEloquent::class,
            OvertimeRepository::class => OvertimeRepositoryEloquent::class
        ];
    }
}
