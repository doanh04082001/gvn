<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class RelationshipProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Relation::morphMap($this->defineMorphMap());
    }

    /**
     * Get morph map array.
     *
     * @return array
     */
    private function defineMorphMap()
    {
        return [
            Customer::MORPH_KEY => Customer::class,
            Store::MORPH_KEY => Store::class,
            Product::MORPH_KEY => Product::class,
        ];
    }
}
