<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Currency;
use App\Enums\Project;
use App\Models\Payment;
use App\Helper;

class RefundFactory
{
    /**
     * Create a fake Refund model with random values.
     */
    public static function create(): Payment
    {
        return new Payment(
            uniqid(),
            Payment::REFUND_TYPE,
            rand(1, 999999),
            Currency::random(),
            Helper::fakeCardNumber(),
            Project::random(),
            Payment::PENDING_STATUS,
            uniqid(),
        );
    }
}
