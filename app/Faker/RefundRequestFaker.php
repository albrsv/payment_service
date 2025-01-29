<?php

declare(strict_types=1);

namespace App\Faker;

use App\Enums\Project;

class RefundRequestFaker
{
    public static function generate(): array
    {
        return [
            'payment_id' => uniqid(),
            'amount' => rand(1, 999999),
            'operation_id ' => uniqid(),
            'project_id' => Project::random(),
        ];
    }
}
