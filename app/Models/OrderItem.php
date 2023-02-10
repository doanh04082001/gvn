<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'promotion_id',
        'price',
        'sale_price',
        'quantity',
        'note',
    ];

    /**
     * Get the order that owns the order item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that owns the order item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    /**
     * The toppings that belong to the order item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function toppings()
    {
        return $this->belongsToMany(Topping::class)
            ->withTrashed()
            ->withPivot(['quantity', 'price', 'sale_price']);
    }

    /**
     * Get product that is relevant to the order item.
     *
     * @return App\Models\Product
     */
    public function realProduct()
    {
        if ($this->product->parent_id) {
            return $this->product->productWithTrashed;
        }

        return $this->product;
    }

    /**
     * Get order item name.
     *
     * @return string
     */
    public function name()
    {
        if ($this->product->parent_id) {
            return "{$this->realProduct()->name} {$this->product->name}";
        }

        return $this->realProduct()->name;
    }

    /**
     * Get toppings belong to the order item.
     *
     * @return string|null
     */
    public function renderToppings()
    {
        return $this->toppings
            ->map(function ($topping) {
                return "{$topping->pivot->quantity} {$topping->name}";
            })
            ->join(' + ');
    }

    /**
     * Cacualte total real amount
     *
     * @return float
     */
    public function totalRealAmount()
    {
        return ($this->price + $this->totalToppingAmount()) * $this->quantity;
    }

    /**
     * Cacualte total sale amount
     *
     * @return float
     */
    public function totalAmount()
    {
        return ($this->sale_price + $this->totalToppingAmount()) * $this->quantity;
    }

    /**
     * Cacualte total amount of all toppings
     *
     * @return float
     */
    public function totalToppingAmount()
    {
        return $this->toppings->sum(function ($topping) {
            return $topping->pivot->quantity * $topping->pivot->sale_price;
        });
    }

    /**
     * Render key on cart
     *
     * @return string
     */
    public function renderCartKey()
    {
        return $this->product_id
            . '_'
            . $this->toppings->pluck('id')->join('_');
    }

    /**
     * Build query order item with relation
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithAllRelationTrashed($query, $storeId = null)
    {
        return $query
            ->with([
                'toppings' => function ($query) use ($storeId) {
                    if ($storeId) {
                        $query->onlyStore($storeId);
                    }
                    $query->withTrashed();
                },
                'product' => function ($query) use ($storeId) {
                    if ($storeId) {
                        $query->onlyStore($storeId);
                    }
                    $query->withTrashed();
                },
                'product.product' => function ($query) use ($storeId) {
                    if ($storeId) {
                        $query->onlyStore($storeId);
                    }
                    $query->withTrashed();
                },
            ])
            ->withTrashed();
    }
}
