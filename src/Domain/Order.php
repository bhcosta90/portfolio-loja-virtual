<?php

declare(strict_types=1);

namespace Domain;

use function array_column;
use function array_map;

class Order
{
    /** @param OrderProduct[] $products */
    protected array $products = [];

    /** @param OrderPayment[] $products */
    protected array $payments = [];

    public function __construct(
        protected string $customer,
        protected string $address,
        protected int $shipping,
    ) {
        //
    }

    public function getCustomer(): string
    {
        return $this->customer;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getShipping(): int
    {
        return $this->shipping;
    }

    public function getTotal(): int
    {
        $serializeProduct = array_map(fn(OrderProduct $product) => ['price' => $product->getTotal()], $this->products);
        return array_sum(array_column($serializeProduct, 'price')) + $this->shipping;
    }

    public function addProduct(OrderProduct $product): void
    {
        $this->products[] = $product;
    }

    /**
     * @throws OrderNoItemException
     */
    public function addPayment(OrderPayment $payment): void
    {
        if(count($this->products) === 0){
            throw new OrderNoItemException();
        }
        $this->payments[] = $payment;
    }
}
