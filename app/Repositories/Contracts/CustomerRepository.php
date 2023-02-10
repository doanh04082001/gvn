<?php

namespace App\Repositories\Contracts;

use App\Models\Customer;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CustomerRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface CustomerRepository extends RepositoryInterface
{
    /**
     * Store customer's device token
     *
     * @param \App\Models\Customer $customer
     * @param mixed $token
     * @return null
     */
    public function storeDeviceToken(Customer $customer, $token);

    /**
     * Delete customer's device token
     *
     * @return null
     */
    public function deleteDeviceToken();

    /**
     * DataTables using Eloquent Builder.
     *
     * @param array $params
     * @return Yajra\DataTables\EloquentDataTable
     */
    public function getCustomerDataTable($params);

    /**
     * Activate customer
     *
     * @param string $id
     * @return mixed
     */
    public function activate(string $id);

    /**
     * Change customer notification state
     *
     * @param int $state
     * @return Customer
     */
    public function changeNotificationState($state);

    /**
     * Update change password.
     *
     * @param $params
     * @return App\Models\Customer
     */
    public function changePassword($params);

    /**
     * Get customer by phone number
     *
     * @param mixed $phone
     * @return \App\Models\Customer|void
     */
    public function firstByPhone($phone);

    /**
     * Get customer's favorite products
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getFavoriteProducts();

    /**
     * Get customer's favorite stores
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getFavoritedStores();

    /**
     * Store a newly created customer in database.
     *
     * @param Array $data
     * @return Customer
     */
    public function store($data);

    /**
     * Verify customer
     *
     * @param string $id
     * @return mixed|void
     */
    public function verify(string $id);

    /**
     * Check is unverified
     *
     * @param mixed $phone
     * @return boolean
     */
    public function hasVerified($phone);

    /**
     * Get total customer created in today.
     *
     * @param string $timezone
     * @return mixed
     */
    public function getTotalCustomerCreatedToday($timezone = DEFAULT_CLIENT_TIMEZONE);

    /**
     * Customer favorite / unfavorite store
     *
     * @param string $storeId
     * @return mixed
     */
    public function changeFavoriteStore($storeId);

    /**
     * Get customer's favorite stores
     *
     * @return int
     */
    public function getNotificationState();

    /**
     * Create favorite in store.
     *
     * @param string $storeId
     * @return void
     */
    public function favoriteStore($storeId);

    /**
     * Delete favorite in store.
     *
     * @param string $storeId
     * @return int
     */
    public function unfavoriteStore($storeId);

    /**
     * Get customers by phone
     *
     * @param mixed $phone
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getByPhone($phone);

    /**
     * Find customer by phone
     *
     * @param mixed $phone
     * @return Customer|null
     */
    public function findByPhone($phone);
}
