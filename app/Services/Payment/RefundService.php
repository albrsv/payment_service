<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\DTO\RefundDTO;
use App\Models\Payment;
use App\Exceptions\TransactionAlreadyExistsException;
use App\Repositories\PaymentRepository;
use App\Repositories\PaymentRepositoryFactory;
use App\Services\ProjectGateway\ProjectFactory;
use App\Services\ProjectGateway\ProjectFactoryInterface;

class RefundService
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
        // Check if a Refund with the same ID already exists
        if ($this->paymentRepository->find($this->data['payment_id'], $this->data['project_id'])) {
            throw new TransactionAlreadyExistsException();
        }

        // Find payment or throw an exception
        $payment = $this->paymentRepository->findOrFail($this->data['operation_id'], $this->data['project_id']);

        // Initialize Payment
        $refund = new Payment(
            $this->data['payment_id'],
            Payment::REFUND_TYPE,
            $payment->amount,
            $payment->currency,
            $this->data['pan'],
            $this->data['project_id'],
            Payment::PENDING_STATUS,
            $this->data['operation_id'],
        );

        // Store Payment data with pending status to db 
        $this->paymentRepository->save($refund);

        // Initialize the project factory
        $factory = new ProjectFactory();

        // Get an external project service by ID
        $project = $factory->getProjectById($this->data['project_id']);

        // Initialize RefundDTO
        $refundDTO = new RefundDTO(
            $this->data['payment_id'],
            $this->data['operation_id '],
            $refund->amount,
            $refund->currency,
            $this->data['pan'],
        );

        // Send Refund to the Project
        $projectResponse = $project->refund($refundDTO);

        // Set the payment status using the response status
        $refund->status = $projectResponse->responseStatusToStr();

        // Update Refund
        $this->paymentRepository->save($refund);

        return $refund;
    }
}
