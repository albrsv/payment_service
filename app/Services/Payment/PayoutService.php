<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\DTO\PayoutDTO;
use App\Models\Payment;
use App\Exceptions\TransactionAlreadyExistsException;
use App\Repositories\PaymentRepository;
use App\Repositories\PaymentRepositoryFactory;
use App\Services\ProjectGateway\ProjectFactory;
use App\Services\ProjectGateway\ProjectFactoryInterface;

class PayoutService
{
    protected PaymentRepository $paymentRepository;
    protected ProjectFactoryInterface $projectFactory;
    protected array $data;

    public function __construct(array $data, ?ProjectFactoryInterface $projectFactory = null)
    {
        $this->data = $data;

        if ($projectFactory === null) {
            $this->projectFactory = new ProjectFactory();
        }

        $this->paymentRepository = (new PaymentRepositoryFactory())->create();
    }

    public function process(): Payment
    {
        // Check if a Payout with the same ID already exists
        if ($this->paymentRepository->find($this->data['payment_id'], $this->data['project_id'])) {
            throw new TransactionAlreadyExistsException();
        }

        // Initialize Payment
        $payout = new Payment(
            $this->data['payment_id'],
            Payment::PURCHASE_TYPE,
            $this->data['amount'],
            $this->data['currency'],
            $this->data['pan'],
            $this->data['project_id'],
            Payment::PENDING_STATUS,
        );

        // Store Payout data with pending status to db 
        $this->paymentRepository->save($payout);

        // Initialize the project factory
        $factory = new ProjectFactory();

        // Get the service based on the service_id
        $project = $factory->getProjectById($this->data['project_id']);

        // Initialize PayoutDTO
        $payoutDTO = new PayoutDTO(
            $this->data['payment_id'],
            $this->data['amount'],
            $this->data['currency'],
            $this->data['pan'],
        );

        // Send Payout to the Project
        $projectResponse = $project->payout($payoutDTO);

        // Set the payment status using the response status
        $payout->status = $projectResponse->responseStatusToStr();

        // Update Refund
        $this->paymentRepository->save($payout);

        return $payout;
    }
}
