<?php

declare(strict_types=1);

namespace App\Models;

class Payment
{
    public const PURCHASE_TYPE = 'purchase';
    public const PAYOUT_TYPE = 'payout';
    public const REFUND_TYPE = 'refund';

    public const PENDING_STATUS = 'pending';
    public const SUCCESS_STATUS = 'success';
    public const FAILURE_STATUS = 'failure';
    public const BAD_REQUEST_STATUS = 'bad_request';

    public function __construct(
        public string $paymentId,
        public string $type,
        public int $amount,
        public string $currency,
        public string $pan,
        public string $projectId,
        public string $status,
        public ?string $operationId = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
    ) {
        if (!isset($this->createdAt)) {
            $this->createdAt = date('Y-m-d H:i:s');
        }
    }
}
