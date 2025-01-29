<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Currency;
use App\Enums\Project;
use App\Models\Payment;
use App\Helper;

class PayoutFactory
{
    /**
     * Create a fake Payout model with random values.
     */
    public static function create(): Payment
    {
        return new Payment(
            uniqid(),
            Payment::PAYOUT_TYPE,
            rand(1, 999999),
            Currency::random(),
            Helper::fakeCardNumber(),
            Project::random(),
            Payment::PENDING_STATUS,
        );
    }
}
