<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepository;
use App\Repositories\Traits\DeviceToken;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CustomerRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CustomerRepositoryEloquent extends BaseRepository implements CustomerRepository
{
    use DeviceToken;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Customer::class;
    }

    /**
     * Get customer's favorite products
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getFavoriteProducts()
    {
        return auth()->user()->products;
    }

    /**
     * Get customer's favorite stores
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getFavoritedStores()
    {
        return auth()->user()->stores;
    }

    /**
     * DataTables using Eloquent Builder.
     *
     * @param  array $params
     * @return Yajra\DataTables\EloquentDataTable
     */
    public function getCustomerDataTable($params)
    {
        return datatables()
            ->eloquent(
                $this->model->query()
            )
            ->filterColumn('points', function ($query) use ($params) {
                if (!empty($params['min_point'])) {
                    $query->where('customers.points', '>=', $params['min_point']);
                }
                if (!empty($params['max_point'])) {
                    $query->where('customers.points', '<=', $params['max_point']);
                }
            })
            ->filterColumn('orders_count', function ($query) use ($params) {
                if (!empty($params['min_order'])) {
                    $query->where('customers.orders_count', '>=', $params['min_order']);
                }
                if (!empty($params['max_order'])) {
                    $query->where('customers.orders_count', '<=', $params['max_order']);
                }
            });
    }

    /**
     * Store a newly created customer in database.
     *
     * @param Array $data
     * @return Customer
     */
    public function store($data)
    {
        return $this->create(
            array_merge($data, [
                'password' => bcrypt(Str::random(20)),
            ])
        );
    }

    /**
     * Activate customer
     *
     * @param string $id
     * @return mixed|void
     */
    public function activate(string $id)
    {
        return $this->find($id)->update(['status' => Customer::STATUS_ACTIVE]);
    }

    /**
     * Change customer notification state
     *
     * @param int $state
     * @return Customer
     */
    public function changeNotificationState($state)
    {
        $customer = auth()->user();
        $setting = $customer->setting ?? [];
        $setting['notification_state'] = (int) $state;

        return $customer->update(['setting' => $setting]);
    }

    /**
     * Update change password.
     *
     * @param $params
     * @return App\Models\Customer
     */
    public function changePassword($params)
    {
        return $this->update(
            [
                'password' => bcrypt($params['password']),
                'verified_at' => now(),
            ],
            auth()->user()->id
        );
    }

    /**
     * Verify customer
     *
     * @param string $id
     * @return mixed|void
     */
    public function verify(string $id)
    {
        return $this->update(['verified_at' => now()], $id);
    }

    /**
     * Check is unverified
     *
     * @param mixed $phone
     * @return boolean
     */
    public function hasVerified($phone)
    {
        $customer = $this->firstByPhone($phone);

        return !!($customer->verified_at ?? false);
    }

    /**
     * Get customer by phone number
     *
     * @param  mixed $phone
     * @return App\Models\Customer|void
     */
    public function firstByPhone($phone)
    {
        return $this->where('phone', $phone)->first();
    }

    /**
     * Get total customer created in today.
     *
     * @param string $timezone
     * @return mixed
     */
    public function getTotalCustomerCreatedToday($timezone = DEFAULT_CLIENT_TIMEZONE)
    {
        $timestamp = Carbon::now()->setTimezone($timezone);
        $startDay = $timestamp->copy()->startOfDay()->setTimezone(config('app.timezone'));
        $endDay = $timestamp->copy()->endOfDay()->setTimezone(config('app.timezone'));

        return $this->whereNotNull('verified_at')
            ->whereBetween('created_at', [$startDay, $endDay])
            ->count();
    }

    /**
     * Customer favorite / unfavorite store
     *
     * @param string $storeId
     * @return bool
     */
    public function changeFavoriteStore($storeId)
    {
        if (auth()->user()->isFavoriteStore($storeId)) {
            $this->unfavoriteStore($storeId);

            return false;
        }
        $this->favoriteStore($storeId);

        return true;
    }

    /**
     * Create favorite in store.
     *
     * @param string $storeId
     * @return void
     */
    public function favoriteStore($storeId)
    {
        return auth()->user()->stores()->attach($storeId);
    }

    /**
     * Delete favorite in store.
     *
     * @param string $storeId
     * @return int
     */
    public function unfavoriteStore($storeId)
    {
        return auth()->user()->stores()->detach($storeId);
    }

    /**
     * Get customer's notification status
     *
     * @return int
     */
    public function getNotificationState()
    {
        return auth()->user()->setting['notification_state'];
    }

    /**
     * Get customers by phone
     *
     * @param mixed $phone
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getByPhone($phone)
    {
        return $this->where('phone', 'like', '%' . escapeLike(strval($phone)) . '%')
            ->with('lastShippingAddress')
            ->take(Customer::LIMIT_ITEMS)
            ->get();
    }

    /**
     * Find customer by phone
     *
     * @param string $phone
     * @return Customer|null
     */
    public function findByPhone($phone)
    {
        return $this->where('phone', $phone)->first();
    }
}
