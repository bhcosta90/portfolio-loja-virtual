<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use Domain\Order;
use Domain\OrderPayment;
use Domain\OrderProduct;
use Domain\Repository\OrderRepositoryInterface;

use function array_map;

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

        array_map(fn (OrderProduct $orderProduct) => $orderDb->products()->create([
            'product_id' => $orderProduct->getId(),
            'name' => $orderProduct->getName(),
            'value' => $orderProduct->getValue(),
            'quantity' => $orderProduct->getQuantity(),
        ]), $order->getProducts());

        array_map(fn (OrderPayment $orderPayment) => $orderDb->payments()->create([
            'value' => $orderPayment->getValue(),
            'type' => $orderPayment->getType(),
            'credit_card' => $orderPayment->getCreditCard(),
        ]), $order->getPayments());

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
