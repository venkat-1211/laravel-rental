<?php

namespace Modules\Auth\Helpers;

class CommonHelper
{
    public static function generate(int $digits = 6): string
    {
        $min = (int) str_pad('1', $digits, '0'); // 100000
        $max = (int) str_pad('', $digits, '9');  // 999999

        return (string) random_int($min, $max);
    }
}
