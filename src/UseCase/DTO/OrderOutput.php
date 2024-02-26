<?php

declare(strict_types=1);

namespace UseCase\DTO;

use Domain\Order;

class OrderOutput
{
    protected function __construct(public int $total)
    {
    }

    public static function make(Order $order): self
    {
        return new self(
            total: $order->getTotal(),
        );
    }
}
