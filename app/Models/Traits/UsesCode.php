<?php

namespace App\Models\Traits;

trait UsesCode
{
    /**
     * Overide boot model to create code for model
     *
     */
    protected static function bootUsesCode()
    {
        self::creating(function ($model) {
            $model->code = generateUniqueCode();
        });
    }
}
