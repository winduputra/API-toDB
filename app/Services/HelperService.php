<?php

namespace App\Services;

class HelperService
{
    
    public static function moneyFormat($number)
    {
        return number_format(self::sanitizeNumber($number),0,',','.');
    }

    public static function sanitizeNumber($number)
    {
        $number = preg_replace("/\D+/", "", $number);
        return intval($number);
    }
}
