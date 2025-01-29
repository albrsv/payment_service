<?php

declare(strict_types=1);

namespace App\DTO;

class RefundDTO
{
    public function __construct(
        private string $paymentId,
        private string $operationId,
        private int $amount,
        private string $currency,
        private string $pan,
    ) {}

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function getOperationId(): string
    {
        return $this->operationId;
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
