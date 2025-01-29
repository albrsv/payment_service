<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Requests\RefundRequest;
use App\Exceptions\ValidationException;
use App\Exceptions\TransactionNotFoundException;
use App\Services\Payment\RefundService;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RefundController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            // Validate request 
            $validated = (new RefundRequest($request))->validate();

            // Process refund
            $refund = (new RefundService($validated))->process();

            // Return the success response to the client even if the Project returns a failure status
            return $this->jsonSuccessResponse($refund->status);
        } catch (TransactionNotFoundException | InvalidArgumentException $e) {
            return $this->jsonFailureResponse($e->getMessage(), code: $e->getCode());
        } catch (ValidationException $e) {
            return $this->jsonFailureResponse($e->getMessage(), $e->getErrors(), $e->getCode());
        }
    }
}
