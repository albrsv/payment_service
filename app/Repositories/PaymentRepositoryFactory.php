<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\PaymentRepository;
use Database\Database;

class PaymentRepositoryFactory
{
    protected Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function create(): PaymentRepository
    {
        return new PaymentRepository($this->database);
    }
}
