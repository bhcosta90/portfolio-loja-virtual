<?php

declare(strict_types=1);

namespace App\Repositories;

use Domain\Order;
use Domain\Repository\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(protected \App\Models\Order $order)
    {
    }

    public function create(Order $order): Order
    {
        $orderDb = $this->order->create([
            'customer_id' => $order->getCustomer(),
            'address_id' => $order->getAddress(),
            'shipping' => $order->getShipping(),
        ]);

        return new Order(
            customer: $orderDb->customer_id,
            address: $orderDb->address_id,
            shipping: $orderDb->shipping,
            id: $orderDb->id
        );
    }
}
