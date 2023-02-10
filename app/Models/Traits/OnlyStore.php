<?php

namespace App\Models\Traits;

trait OnlyStore
{
    /**
     * With only one store
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $storeId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyStore($query, $storeId)
    {
        return $query
            ->with(['stores' => function ($query) use ($storeId) {
                $query->where('id', $storeId);
            }])
            ->whereHas('stores', function ($q) use ($storeId) {
                $q->where('id', $storeId);
            });
    }
}
