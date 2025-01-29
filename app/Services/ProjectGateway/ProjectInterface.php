<?php

declare(strict_types=1);

namespace App\Services\ProjectGateway;

use App\DTO\PurchaseDTO;

interface ProjectInterface
{
    public const SUCCESS_RESPONSE_MESSAGE = 'success';
    public const FAILURE_RESPONSE_MESSAGE = 'failure';
    public const FAILED_REQUEST_STATUS = 'failed_request';

    public function purchase(PurchaseDTO $purchaseDTO);

    public function refund();

    public function payout();

    public function responseStatusToStr();
}
