<?php

declare(strict_types=1);

namespace UseCase\DTO;

use Domain\Order;

class OrderOutput
{
    protected function __construct(
        public string|int $id,
        public int $total,
        public int $shipping,
        public string $customer
    ) {
    }

    public static function make(Order $order): self
    {
        return new self(
            id: $order->getId(),
            total: $order->getTotal(),
            shipping: $order->getShipping(),
            customer: $order->getCustomer(),
        );
    }
}
