<?php

declare(strict_types=1);

namespace App\DTO;

class PurchaseDTO
{
    public function __construct(
        private string $paymentId,
        private int $amount,
        private string $currency,
        private string $pan,
    ) {}

    // Getters
    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getPan(): string
    {
        return $this->pan;
    }
}
