<?php

declare(strict_types=1);

namespace Tests;

use App\Models\Payment;
use App\Exceptions\TransactionAlreadyExistsException;
use App\Faker\PurchaseRequestFaker;
use App\Services\Payment\PurchaseService;
use PHPUnit\Framework\TestCase;
use Tests\Fakes\FakeProjectFactory;

class PurchaseServiceTest extends TestCase
{
    public function test_process_purchase_successfully()
    {
        $purchaseRequest = PurchaseRequestFaker::generate();
        $purchaseRequest['project_id'] = 'fake_project';

        $fakeProjectFactory = new FakeProjectFactory();

        $purchaseService = new PurchaseService($purchaseRequest, $fakeProjectFactory);

        $payment = $purchaseService->process();

        // Assertions
        $this->assertInstanceOf(Payment::class, $payment);
        $this->assertEquals(Payment::SUCCESS_STATUS, $payment->status);
    }

    public function test_process_purchase_throws_exception_if_transaction_exists()
    {
        $purchaseRequest = PurchaseRequestFaker::generate();
        $purchaseRequest['payment_id'] = 'fake';
        $purchaseRequest['project_id'] = 'fake_project';

        $fakeProjectFactory = new FakeProjectFactory();

        $purchaseService = new PurchaseService($purchaseRequest, $fakeProjectFactory);

        $this->expectException(TransactionAlreadyExistsException::class);

        // Execute the method (should throw exception)
        $purchaseService->process();
    }
}
