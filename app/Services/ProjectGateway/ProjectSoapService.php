<?php

declare(strict_types=1);

namespace App\Services\ProjectGateway;

use App\DTO\PurchaseDTO;

class ProjectSoapService implements ProjectInterface
{
    private array $response;

    public function getUrl(): string
    {
        return getenv('PROJECT_JSON_URL');
    }

    public function getPurchaseUrl(): string
    {
        return $this->getUrl() . '/purchase';
    }

    public function getRefundUrl(): string
    {
        return $this->getUrl() . '/refund';
    }

    public function getPayoutUrl(): string
    {
        return $this->getUrl() . '/payout';
    }

    public function purchase(PurchaseDTO $purchaseDTO)
    {
        $this->response['status'] = 200;

        return $this;
    }

    public function refund()
    {
        $this->response['status'] = 200;

        return $this;
    }

    public function payout()
    {
        $this->response['status'] = 200;

        return $this;
    }

    public function responseStatusToStr(): string
    {
        if (!isset($this->response['status'])) {
            return self::FAILED_REQUEST_STATUS;
        }

        if ($this->response['status'] === 400) {
            return self::FAILURE_RESPONSE_MESSAGE;
        }

        return self::SUCCESS_RESPONSE_MESSAGE;
    }
}
