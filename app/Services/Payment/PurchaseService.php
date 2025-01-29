<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Models\Payment;
use App\DTO\PurchaseDTO;
use App\Exceptions\TransactionAlreadyExistsException;
use App\Repositories\PaymentRepository;
use App\Repositories\PaymentRepositoryFactory;
use App\Services\ProjectGateway\ProjectFactory;
use App\Services\ProjectGateway\ProjectFactoryInterface;

class PurchaseService
{
    protected PaymentRepository $paymentRepository;
    protected ProjectFactoryInterface $projectFactory;
    protected array $data;

    public function __construct(array $data, ProjectFactoryInterface $projectFactory = new ProjectFactory())
    {
        $this->data = $data;
        $this->projectFactory = $projectFactory;
        $this->paymentRepository = (new PaymentRepositoryFactory())->create();
    }

    public function process(): Payment
    {
        // Check if a Purchase with the same ID already exists
        if ($this->paymentRepository->find($this->data['payment_id'], $this->data['project_id'])) {
            throw new TransactionAlreadyExistsException();
        }

        // Initialize Payment
        $purchase = new Payment(
            $this->data['payment_id'],
            Payment::PURCHASE_TYPE,
            $this->data['amount'],
            $this->data['currency'],
            $this->data['pan'],
            $this->data['project_id'],
            Payment::PENDING_STATUS
        );

        // Store purchase data with pending status
        $this->paymentRepository->save($purchase);

        // Get an external project service by ID
        $project = $this->projectFactory->getProjectById($this->data['project_id']);

        $purchaseDTO = new PurchaseDTO(
            $this->data['payment_id'],
            $this->data['amount'],
            $this->data['currency'],
            $this->data['pan']
        );

        // Send Purchase to the external service
        $projectResponse = $project->purchase($purchaseDTO);

        // Set the new status based on external response
        $purchase->status = $projectResponse->responseStatusToStr();

        // Update purchase
        $this->paymentRepository->save($purchase);

        return $purchase;
    }
}
