<?php

declare(strict_types=1);

namespace App\Exceptions;

class ValidationException extends \RuntimeException
{
    protected $message = 'Validation error';
    protected $code    = 422;

    public function __construct(protected array $errors = []) {}

    public function getErrors(): array
    {
        return $this->errors;
    }
}
