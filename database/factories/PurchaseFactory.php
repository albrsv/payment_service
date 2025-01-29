<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Currency;
use App\Enums\Project;
use App\Models\Payment;
use App\Helper;

class PurchaseFactory
{
    /**
     * Create a fake Purchase model with random values.
     */
    public static function create(?string $paymentId = null, ?string $projectId = null): Payment
    {
        return new Payment(
            $paymentId ?? 'fake',
            Payment::PURCHASE_TYPE,
            rand(1, 999999),
            Currency::random(),
            Helper::fakeCardNumber(),
            $projectId ?? Project::random(),
            Payment::PENDING_STATUS,
        );
    }
}
