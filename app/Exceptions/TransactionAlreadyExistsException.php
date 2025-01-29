<?php

declare(strict_types=1);

namespace App\Exceptions;

class TransactionAlreadyExistsException extends \RuntimeException
{
    protected $message = 'The transaction already exists';
    protected $code    = 401;
}
