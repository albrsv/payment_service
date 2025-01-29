<?php

declare(strict_types=1);

namespace Tests;

use App\Faker\PurchaseRequestFaker;
use App\Helper;
use PHPUnit\Framework\TestCase;

class PurchaseApiTest extends TestCase
{
    private string $url = 'http://localhost:8000/purchase';

    public function test_purchase_returns_success()
    {
        $payload = PurchaseRequestFaker::generate();

        // Make API request
        $response = Helper::makePostRequest($this->url, $payload);

        // Assert response status
        $this->assertEquals(200, $response['status']);

        // Assert response contains expected data
        $this->assertArrayHasKey('message', $response['body']);
        $this->assertEquals('success', $response['body']['status']);
        $this->assertEquals('success', $response['body']['message']);
    }

    public function test_purchase_returns_validation_error()
    {
        $payload = PurchaseRequestFaker::generate();
        unset($payload['payment_id']);

        // Make API request
        $response = Helper::makePostRequest($this->url, $payload);

        // Assert response status
        $this->assertEquals(422, $response['status']);

        // Assert response contains expected data
        $this->assertArrayHasKey('status', $response['body']);
        $this->assertArrayHasKey('message', $response['body']);
        $this->assertArrayHasKey('data', $response['body']);
        $this->assertEquals('failure', $response['body']['status']);
        $this->assertEquals('Validation error', $response['body']['message']);
    }
}
