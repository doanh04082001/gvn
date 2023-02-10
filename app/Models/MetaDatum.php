<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class MetaDatum extends BaseFileModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'url',
        'description',
        'keyword',
        'image',
    ];

    /**
     * Get the products for the category.
     * Save path file to folder
     *
     * @var string
     */
    protected $fileFolders = ['image' => 'meta-data'];

    /**
     * Save path to column name
     *
     * @var array
     */
    protected $fileFields = ['image'];

    /**
     * Default save on disk (from keys of app/config/filesystem.php > disks)
     *
     * @var string
     */
    protected $saveOnDisk = 'public';
}
