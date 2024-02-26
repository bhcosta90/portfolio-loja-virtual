<?php

declare(strict_types=1);

namespace Domain\Exceptions;

use Exception;

class OrderPaymentCreditCardNotFound extends Exception
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Unreported credit card", $code, $previous);
    }
}
