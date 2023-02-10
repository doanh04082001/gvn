<?php

namespace App\Repositories;

use App\Exceptions\Reviews\ReviewOrderNotCompleteException;
use App\Exceptions\StoreNotExisted;
use App\Models\BaseModel;
use App\Exceptions\Reviews\ReviewExistsException;
use App\Models\Order;
use App\Models\Role;
use App\Models\Product;
use App\Models\Store;
use App\Models\Topping;
use App\Repositories\Contracts\StoreRepository;
use App\Repositories\Traits\Review;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class StoreRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class StoreRepositoryEloquent extends BaseRepository implements StoreRepository
{
    use Review;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Store::class;
    }

    /**
     * Get store list.
     *
     * @param array $params
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getStores(array $params): Collection
    {
        $keyword = $params['keyword'] ?? '';

        return $this->when($keyword != '', function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . escapeLike($keyword) . '%')
                ->orWhere('address', 'like', '%' . escapeLike($keyword) . '%');
        })
            ->get();
    }

    /**
     * Get stores to array $id=>$name.
     *
     * @return array|\Illuminate\Support\Collection
     */
    public function getStoresForSelectBoxOptions()
    {
        return $this->pluck('name', 'id');
    }

    /**
     * Save store reviews.
     *
     * @param \App\Models\Order $order
     * @param array $review
     * @return void
     *
     * @throw App\Exceptions\Reviews\ReviewExistsException;
     */
    public function saveReview(Order $order, array $review)
    {
        if ($order->firstReview) {
            throw new ReviewExistsException();
        }
        if ($order->status != Order::STATUS_DONE) {
            throw new ReviewOrderNotCompleteException();
        }
        $order->store->reviews()->create(array_merge(
            Arr::only($review, [
                'content',
                'images',
                'rating',
            ]),
            [
                'order_id' => $order->id,
                'customer_id' => auth()->id(),
                'store_id' => $order->store->id,
            ]
        ));
    }

    /**
     * Get list stores
     *
     * @param string $voucher
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListStoresWithVoucher($voucher): Collection
    {
        return $this->with(['vouchers' => function ($query) use ($voucher) {
                $query->where('voucher_id', $voucher);
            }])
            ->whereHas('users', function ($query) {
                $query->whereId(auth()->id());
            })
            ->get();
    }

    /**
     * DataTables using Eloquent Builder.
     *
     * @param array $params
     * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\EloquentDataTable
     */
    public function buildDataTablePricing(array $params)
    {
        if (!isset($params['topping_id'])) {
            return datatables()->collection(collect([]));
        }

        $query = auth()->user()->hasRole(Role::SUPER_ADMIN_NAME)
            ? $this->model->query() : auth()->user()->storesWithInactive()->getQuery();

        $query = $query->with([
            'toppingWithInactive' => function ($query) use ($params) {
                $query->withPivot('price', 'sale_price', 'status');
                $query->where('topping_id', $params['topping_id']);
            }
        ]);

        if ($params['status'] != '') {
            $query = $query->whereHas('toppingWithInactive', function ($query) use ($params) {
                $query->where('store_topping.status', $params['status']);
                $query->where('topping_id', $params['topping_id']);
            });
        }

        return dataTables()->eloquent($query);
    }

    /**
     * Save topping
     *
     * @param array $data
     * @return mixed|void
     */
    public function updateStoreTopping(array $data)
    {
        $store = $this->model->find($data['store_id']);

        $pivotData = [
            'price' => $data['price'],
            'sale_price' => $data['sale_price'],
            'status' => $data['status'] ?? BaseModel::STATUS_ACTIVE,
        ];

        $topping = $store->toppingWithInactive()
            ->withPivot('price', 'sale_price', 'status')
            ->find($data['topping_id']);
        if ($topping) {
            return $topping->pivot->update($pivotData);
        }

        return $store->toppingWithInactive()->attach([$data['topping_id'] => $pivotData]);

    }

    /**
     * Change status store topping
     *
     * @param Store $store
     * @param Topping $topping
     * @param $status
     * @return mixed|void
     */
    public function changeStoreToppingStatus(Store $store, Topping $topping, $status)
    {
        return $store->toppingWithInactive()->find($topping->id)->pivot->update(compact('status'));
    }

    /**
     * Attach topping to all store
     *
     * @param Topping $topping
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function attachTopping(
        Topping $topping,
        array $params
    ) {
        return $this->getStoresForAdmin()->each(function ($store) use ($topping, $params) {
            $store->toppingWithInactive()->attach([
                $topping->id => [
                    'price' => $params['price'],
                    'sale_price' => $params['sale_price'],
                    'status' => BaseModel::STATUS_ACTIVE,
                ]
            ]);
        });
    }

    /**
     * Update toppings
     *
     * @param array $params
     * @return array
     */
    public function updateManyStoreTopping(array $params): array
    {
        return array_map(function ($param) {
            return $this->updateStoreTopping($param);
        }, $params);
    }

    /**
     * Get stores with current admin
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getStoresForAdmin(): Collection
    {
        $admin = auth()->user();

        return $admin->isSuperAdmin()
            ? $this->get()
            : $admin->stores;
    }

    /**
     * DataTables using Eloquent Builder.
     *
     * @param array $params
     * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\EloquentDataTable
     */
    public function buildDatatableProductPrice(array $params)
    {
        if (!isset($params['product_id'])) {
            return datatables()->collection(collect([]));
        }

        $query = auth()->user()->hasRole(Role::SUPER_ADMIN_NAME) ?
            $this->model : auth()->user()->stores();

        $query = $query->with([
            'allProducts' => function ($query) use ($params) {
                $query->withPivot('price', 'sale_price', 'featured', 'status');
                $query->where('product_id', $params['product_id']);
            }
        ]);

        if (isset($params['featured']) && $params['featured'] != '') {
            $query = $query->whereHas('allProducts', function ($query) use ($params) {
                $query->where('product_store.featured', $params['featured']);
                $query->where('product_id', $params['product_id']);
            });
        }

        if (isset($params['status']) && $params['status'] != '') {
            $query = $query->whereHas('allProducts', function ($query) use ($params) {
                $query->where('product_store.status', $params['status']);
                $query->where('product_id', $params['product_id']);
            });
        }

        return dataTables()->eloquent($query);
    }

    /**
     * Save product
     *
     * @param array $data
     * @return mixed
     */
    public function updateStoreProduct(array $data)
    {
        $store = $this->model->find($data['store_id']);

        $pivotData = [
            'price' => $data['price'],
            'sale_price' => $data['sale_price'],
            'status' => $data['status'] ?? BaseModel::STATUS_ACTIVE
        ];

        $product = $store->allProducts()->find($data['product_id']);
        if ($product) {
            return $product->pivot->update($pivotData);
        }

        return $store->allProducts()->attach([
            $data['product_id'] => $pivotData
        ]);
    }

    /**
     * Check product can be update in store
     *
     * @param Store $store
     * @param Product $product
     * @return mixed
     */
    public function canUpdateProductOnStore(Store $store, Product $product)
    {
        if (auth()->user()->isSuperAdmin() || $store->users()->where('id', auth()->id())->exists()) {
            return $store->allProducts()->find($product->id);
        }

        return null;
    }

    /**
     * Update products
     *
     * @param array $params
     * @return array
     */
    public function updateManyStoreProduct(array $params): array
    {
        return array_map(function ($param) {
            return $this->updateStoreProduct($param);
        }, $params);
    }

    /**
     * Get current store
     *
     * @return Store
     */
    public function getCurrentStoreSession(): Store
    {
        return session()->get(config('params.store.current_store')) ?? $this->first();
    }
        
    /**
     * Get address for shipping fee
     *
     * @param string $store_id
     * @return string
     */
    public function getAddressForShippingFee(string $store_id)
    {
        $store = $this->find($store_id);
        
        return $store->latitude && $store->longitude
            ? "{$store->latitude}, {$store->longitude}"
            : $store->address;
    }

    /**
     * Get address of store for shipping fee
     *
     * @param string $storeId
     * @return array
     * @throws StoreNotExisted
     */
    public function getStoreAddressById($storeId)
    {
        $store = $this->find($storeId);

        if (!$store) {
            throw new StoreNotExisted();
        }

        if ($store->latitude && $store->longitude) {
            return [
                'lat' => $store->latitude,
                'lng' => $store->longitude,
                'address' => '',
            ];
        }

        return [
            'lat' => '',
            'lng' => '',
            'address' => $store->address,
        ];
    }

    /**
     * Apply voucher to all stores
     *
     * @param \App\Models\Voucher $voucher
     * @return void
     */
    public function applyVoucherAllStores($voucher)
    {
        $voucher->stores()->sync($this->all()->pluck('id'));
    }
}
