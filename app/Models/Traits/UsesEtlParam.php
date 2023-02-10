<?php

namespace App\Models\Traits;

trait UsesEtlParam
{
    /**
     * Overide boot model to create code for model
     *
     */
    protected static function transformParams($options)
    {
        if (!empty($options['all'])) {
            $to_date = null;

            $from_date = null;
        } else if (empty($options['from_date']) && empty($options['to_date'])) {
            $from_date = ($max_date_db = $options['model']::max('date_id'))
                ? date_create_from_format('Ymd', $max_date_db)->format('Y-m-d')
                : null;

            $to_date = null;
        }

        return [
            'from_date' => $from_date ?? $options['from_date'],
            'to_date' => $to_date ?? $options['to_date']
        ];
    }
}
