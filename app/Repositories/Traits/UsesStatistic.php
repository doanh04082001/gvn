<?php

namespace App\Repositories\Traits;

use Carbon\Carbon;

trait UsesStatistic
{
    /**
     * Add filter query
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param array $params
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function addFilterQuery($query, $params)
    {
        $from_date = isset($params['from_date'])
            ? date_format(date_create($params['from_date']), 'Ymd')
            : null;

        $to_date = isset($params['to_date'])
            ? date_format(date_create($params['to_date']), 'Ymd')
            : null;

        return $query->when(!auth()->user()->isSuperAdmin(), function($q){
                $q->whereIn('store_id', auth()->user()->stores->pluck('id'));
            })
            ->when(isset($params['store_id']), function($q) use ($params) {
                $q->where('store_id', $params['store_id']);
            })
            ->when($from_date, function($q) use ($from_date){
                $q->where('date_id', '>=', $from_date);
            })
            ->when($to_date, function($q) use ($to_date){
                $q->where('date_id', '<=', $to_date);
            });
    }
}
