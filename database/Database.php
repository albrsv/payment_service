<?php

declare(strict_types=1);

namespace Database;

use App\Models\Payment;
use Database\Factories\PurchaseFactory;

class Database implements DatabaseInterface
{
    public function connect()
    {
        //
    }
    
    public function find(string $paymentId, string $projectId): ?Payment
    {
        return null;
        // return $this->findExisted($id); 
    }

    public function findExisted(string $paymentId, string $projectId): ?Payment
    {
        return PurchaseFactory::create($paymentId, $projectId);
    }

    public function save()
    {
        //
    }
}
