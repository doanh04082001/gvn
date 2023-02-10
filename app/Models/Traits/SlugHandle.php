<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait SlugHandle
{
    /**
     * Overide boot model to create slug
     *
     */
    public static function bootSlugHandle()
    {
        self::creating(function ($model) {
            $slug = Str::slug($model->slugByField());

            $latestSlug = self::where('slug', 'LIKE', "{$slug}%")
                ->latest()
                ->value('slug');

            if ($latestSlug) {
                $pieces = explode($slug, $latestSlug);
                $number = intval(trim(end($pieces), '-'));
                $slug .= '-' . ($number + 1);
            }

            $model->slug = $slug;
        });
    }

    /**
     * Render slug by field
     *
     * @return string
     */
    private function slugByField()
    {
        if (method_exists($this, 'slugable')) {
            return $this->slugable();
        }

        return $this->name;
    }
}
