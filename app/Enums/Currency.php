<?php

declare(strict_types=1);

namespace App\Enums;

enum Currency
{
    case USD;
    case EUR;
    case RSD;
    case GBP;

    public static function random(): string
    {
        $currencies = self::cases();

        return $currencies[array_rand($currencies)]->name;
    }
}
