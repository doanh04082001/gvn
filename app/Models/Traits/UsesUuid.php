<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait UsesUuid
{
    /**
     * Overide boot model to create Uuid for primary key
     *
     */
    protected static function bootUsesUuid()
    {
        self::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });

        self::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy($builder->getModel()->getTable() . '.created_at', 'desc');
        });
    }
}
