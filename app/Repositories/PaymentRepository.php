<?php

declare(strict_types=1);

namespace App\Repositories;

use App\models\Payment;
use App\Exceptions\TransactionNotFoundException;
use Database\Database;
use Database\DatabaseInterface;

class PaymentRepository
{
    protected Database $db;
    private string $table = 'payments';

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function find(string $paymentId, string $projectId): ?Payment
    {
        return $this->db->find($paymentId, $projectId);
    }

    public function findExisted(string $paymentId, string $projectId): ?Payment
    {
        return $this->db->findExisted($paymentId, $projectId);
    }

    public function findOrFail(string $paymentId, string $projectId): Payment
    {
        $payment = $this->db->find($paymentId, $projectId);

        if (!$payment) {
            throw new TransactionNotFoundException();
        }

        return $payment;
    }

    public function save(Payment $payment): void
    {
        $this->db->save($payment, $this->table);
    }
}
