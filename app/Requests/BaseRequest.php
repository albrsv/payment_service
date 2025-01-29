<?php

declare(strict_types=1);

namespace App\Requests;

use App\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseRequest
{
    protected array $content;

    public function __construct(Request $request)
    {
        if (empty($request->getContent())) {
            throw new ValidationException(['empty body']);
        }

        $this->content = $request->toArray();
    }

    abstract public function validate();
}
