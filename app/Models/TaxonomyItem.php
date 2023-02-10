<?php

namespace App\Models;

use App\Models\Traits\SlugHandle;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaxonomyItem extends BaseFileModel
{
    use HasFactory, SlugHandle;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'taxonomy_id',
        'name',
        'image',
        'status',
        'slug',
        'order',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'deleted_at',
        'created_at',
    ];

    /**
     * Default save on disk (from keys of app/config/filesystem.php > disks)
     *
     * @var string
     */
    protected $saveOnDisk = 'public';

    /**
     * Save path file to folder
     *
     * @var string
     */
    protected $fileFolders = ['image' => 'taxonomy-items'];

    /**
     * Save path to column name
     *
     * @var array
     */
    protected $fileFields = ['image'];

    /**
     * Get the products for the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id')->where('status', Product::STATUS_ACTIVE);
    }

    /**
     * Get the taxonomy that owns the taxonomy item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class);
    }
}
