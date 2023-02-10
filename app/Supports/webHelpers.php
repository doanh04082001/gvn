<?php

use Illuminate\Support\Carbon;

/*
 *--------------------------------------------------------------------------
 * Web's helpers
 *--------------------------------------------------------------------------
 *
 * Here is where you can write helpers function for project
 * You need run:  composer dump-autoload to load functions writed
 *
 */

if (!function_exists('shortNumberFormat')) {
    /**
     * Abbreviated a number
     *
     * @param int $number
     * @return string $formated_number
     */
    function shortNumberFormat(int $number): string
    {
        if (1000000 > $number && $number >= 1000) {
            $formated_number = number_format($number / 1000, 0) . 'K';
        } else if ($number >= 1000000) {
            $formated_number = number_format($number / 1000000, 0) . 'M';
        } else {
            $formated_number = strval($number);
        }

        return $formated_number;
    }
}

if (!function_exists('formatUtcToOffset')) {
    /**
     * convert time form utc to timezone offset with format string
     *
     * @param string $datetime
     * @param string $formatString
     * @param float $toOffset
     * @return string $code
     */
    function formatUtcToOffset($datetime, $formatString = 'H:i - d/m/Y', $toOffset = 7): string
    {
        return Carbon::create($datetime)
            ->addHours($toOffset)
            ->format($formatString);
    }
}

if (!function_exists('formatNumberWithSuffix')) {
    /**
     * convert time form utc to timezone offset with format string
     * @param float $amount
     * @param string $suffix
     * @return string $code
     */
    function formatNumberWithSuffix($amount, $suffix = null): string
    {
        $suffix !== '' && ($suffix = ' ' . ($suffix ?? __('web.currency.vnd')));
        
        return number_format($amount, 0, ',', '.') . $suffix;
    }
}
