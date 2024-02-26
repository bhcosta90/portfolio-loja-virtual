<?php

declare(strict_types=1);

namespace Domain\Events;

use Contracts\EventInterface;
use Domain\Order;

class OrderCreateEvent implements EventInterface
{
    public function __construct(protected Order $order)
    {
    }

    public function payload(): array
    {
        return [
            'id' => $this->order->getId(),
        ];
    }

}
