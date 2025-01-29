<?php

declare(strict_types=1);

namespace App\Faker;

use App\Enums\Currency;
use App\Enums\Project;
use App\Helper;

class PurchaseRequestFaker
{
    public static function generate(): array
    {
        return [
            'payment_id' => uniqid(),
            'amount' => rand(1, 999999),
            'currency' =>  Currency::random(),
            'pan' => Helper::fakeCardNumber(),
            'project_id' => Project::random(),
        ];
    }
}
