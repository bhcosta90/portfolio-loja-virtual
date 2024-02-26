<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use Domain\Order;
use Domain\Repository\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(protected \App\Models\Order $order, protected Product $product)
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

    public function getByProducts(array $ids): array
    {
        return $this->product->whereIn('id', $ids)->get()->keyBy('id')->toArray();
    }


}
