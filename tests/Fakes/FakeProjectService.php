<?php

declare(strict_types=1);

namespace Tests\Fakes;

use App\Services\ProjectGateway\ProjectInterface;
use App\DTO\PurchaseDTO;

class FakeProjectService implements ProjectInterface
{
    private array $response;

    public function purchase(PurchaseDTO $purchaseDTO)
    {
        // Fake response
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

    public function refund()
    {
        //
    }

    public function payout()
    {
        //
    }
}
