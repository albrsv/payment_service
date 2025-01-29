<?php

declare(strict_types=1);

namespace App\Exceptions;

class TransactionNotFoundException extends \RuntimeException
{
    protected $message = 'Transaction not found';
    protected $code    = 404;
}
