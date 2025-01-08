<?php

namespace App\Helper;

class IdentifierGeneratorHelper
{
    public static function generateRandomPaymentNumber(): string
    {
        $random = random_int(1000, 9999);
        
        return "R-" . date("Ymd") . "-" . $random;
    }
}
