<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ActiveQuery
{
    /**
     * Get records has active status
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->where($this->getTable() . '.status', self::STATUS_ACTIVE);
    }
}
