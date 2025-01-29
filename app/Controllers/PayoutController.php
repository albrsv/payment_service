<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Requests\PayoutRequest;
use App\Exceptions\ValidationException;
use App\Exceptions\TransactionNotFoundException;
use App\Services\Payment\PayoutService;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PayoutController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            // Validate request 
            $validated = (new PayoutRequest($request))->validate();

            // Process Payout
            $payout = (new PayoutService($validated))->process();

            // Return the success response to the client even if the Project returns a failure status
            return $this->jsonSuccessResponse($payout->status);
        } catch (TransactionNotFoundException | InvalidArgumentException $e) {
            return $this->jsonFailureResponse($e->getMessage(), code: $e->getCode());
        } catch (ValidationException $e) {
            return $this->jsonFailureResponse($e->getMessage(), $e->getErrors(), $e->getCode());
        }
    }
}
