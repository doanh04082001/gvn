<?php

namespace App\Models;

use App\Models\Traits\ActiveQuery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taxonomy extends Model
{
    use SoftDeletes, ActiveQuery;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const PRODUCT_CATEGORY_ID = 1;
    const PRODUCT_UNIT_ID = 2;
    const TAG_REVIEW_ID = 3;

    /**
     * Get the taxonomy items for the taxonomy.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taxonomyItems()
    {
        return $this->hasMany(TaxonomyItem::class);
    }
}
