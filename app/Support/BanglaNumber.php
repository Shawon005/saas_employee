<?php

namespace App\Support;

class BanglaNumber
{
    protected static array $bnDigits = ['0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪', '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯'];

    public static function digits(string|int|float $value): string
    {
        return strtr((string) $value, static::$bnDigits);
    }

    public static function moneyInWords(float $amount): string
    {
        return trim(static::digits(number_format($amount, 2)) . ' টাকা');
    }
}
