<?php

namespace App\Repositories\Traits;

trait Review
{
    /**
     * Calculate rating.
     *
     * @param string $id
     *
     * @return void
     */
    public function calculateRating($id)
    {
        $reviewable = $this->find($id);
        $ratingCount = $reviewable->reviews()->count();

        $reviewable->update([
            'rating_count' => $ratingCount,
            'rating' => round($reviewable->reviews()->sum('rating') / $ratingCount, 1)
        ]);
    }
}
