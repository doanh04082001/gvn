<?php

namespace App\Models;

use App\Models\Traits\UsesEtlParam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductStatistic extends Model
{
    use UsesEtlParam;

    const PRODUCT_TYPE = 1;
    const TOPPING_TYPE = 2;
    const DISCOUNT_TYPE = 3;
    
    public static function etl($options) {
        $params = self::transformParams(
            array_merge(
                $options,
                ['model' => self::class]
            )
        );
        
        DB::statement(
            'call product_statistic_procedure(?, ?)',
            [
                $params['from_date'],
                $params['to_date']
            ]
        );
    }
}
