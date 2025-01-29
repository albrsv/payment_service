<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\TransactionNotFoundException;
use App\Requests\PurchaseRequest;
use App\Exceptions\ValidationException;
use App\Services\Payment\PurchaseService;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PurchaseController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            // Validate request
            $validated = (new PurchaseRequest($request))->validate();

            // Process purchase
            $purchase = (new PurchaseService($validated))->process();

            // Return the success response to the client even if the Project returns a failure status
            return $this->jsonSuccessResponse($purchase->status);
        } catch (TransactionNotFoundException | InvalidArgumentException $e) {
            return $this->jsonFailureResponse($e->getMessage(), code: $e->getCode());
        } catch (ValidationException $e) {
            return $this->jsonFailureResponse($e->getMessage(), $e->getErrors(), $e->getCode());
        }
    }
}
