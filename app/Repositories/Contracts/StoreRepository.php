<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\Topping;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface StoreRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface StoreRepository extends RepositoryInterface
{
    /**
     * Get store list.
     *
     * @param array $params
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getStores(array $params): Collection;

    /**
     * Get stores to array $id=>$name.
     *
     * @return array|\Illuminate\Support\Collection
     */
    public function getStoresForSelectBoxOptions();

    /**
     * Save store reviews.
     *
     * @param \App\Models\Order $order
     * @param array $review
     * @return null
     */
    public function saveReview(Order $order, array $review);

    /**
     * Calculate store rating.
     *
     * @param string $storeId
     *
     * @return void
     */
    public function calculateRating($storeId);

    /**
     * Get list stores
     *
     * @param string $voucher
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListStoresWithVoucher($voucher): Collection;

    /**
     * Build data table for pricing
     *
     * @param array $params
     * @return mixed
     */
    public function buildDataTablePricing(array $params);

    /**
     * Save topping
     *
     * @param array $data
     * @return mixed
     */
    public function updateStoreTopping(array $data);

    /**
     * Change status Store Topping
     *
     * @param Store $store
     * @param Topping $topping
     * @param $status
     * @return mixed
     */
    public function changeStoreToppingStatus(Store $store, Topping $topping, $status);

    /**
     * Check product can be update in store
     *
     * @param Store $store
     * @param Product $product
     * @return mixed
     */
    public function canUpdateProductOnStore(Store $store, Product $product);

    /**
     * Attach topping to all store
     *
     * @param Topping $topping
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function attachTopping(Topping $topping, array $params);

    /**
     * Update store topping
     *
     * @param array $params
     * @return mixed
     */
    public function updateManyStoreTopping(array $params);

    /**
     * Get stores with current admin
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getStoresForAdmin(): Collection;

    /**
     * @param array $params
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function buildDatatableProductPrice(array $params);

    /**
     * Get current store
     * @return Store
     */
    public function getCurrentStoreSession(): Store;

    /**
     * Get address of store for shipping fee
     *
     * @param string $storeId
     * @return array
     * @throws App\Exceptions\StoreNotExisted
     */
    public function getStoreAddressById($storeId);

    /**
     * Apply voucher to all stores
     *
     * @param \App\Models\Voucher $voucher
     * @return void
     */
    public function applyVoucherAllStores($voucher);
}
