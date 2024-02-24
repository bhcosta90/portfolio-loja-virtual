<?php

declare(strict_types=1);

namespace Domain;

use Exception;
use Throwable;

class OrderNoItemException extends Exception
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("There is no item listed in the order", $code, $previous);
    }
}
