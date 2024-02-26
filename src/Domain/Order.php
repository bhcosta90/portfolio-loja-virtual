<?php

declare(strict_types=1);

namespace Domain;

use Domain\Exceptions\OrderNoItemException;

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
        public null|int|string $id = null,
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

    public function getId(): int|string|null
    {
        return $this->id;
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
        if (count($this->products) === 0) {
            throw new OrderNoItemException();
        }

        $this->payments[] = $payment;
    }

    /**
     * @return OrderPayment[]
     */
    public function getPayments(): array
    {
        $paymentsWithValueNotNull = array_filter($this->payments, fn (OrderPayment $payment) => $payment->getHasValue()
        );
        $valueWithValueNotNull = array_sum(
            array_column(
                array_map(fn (OrderPayment $payment) => ['total' => $payment->getValue()], $paymentsWithValueNotNull),
                'total'
            )
        );
        $total = ($totalProducts = $this->getTotal()) - $valueWithValueNotNull;

        $paymentsWithValueNull = array_filter($this->payments, fn (OrderPayment $payment) => !$payment->getHasValue());

        $total /= count($paymentsWithValueNull);

        array_map(fn (OrderPayment $payment) => $payment->changeValue((int)$total), $paymentsWithValueNull);

        $totalCalculate = array_sum(
            array_column(
                array_map(fn (OrderPayment $payment) => ['total' => $payment->getValue()], $this->payments),
                'total'
            )
        );

        if ($totalCalculate < $totalProducts) {
            $this->payments[0]->changeValue($this->payments[0]->getValue() + ($totalProducts - $totalCalculate));
        }

        return $this->payments;
    }

    public function getTotal(): int
    {
        $serializeProduct = array_map(fn (OrderProduct $product) => ['price' => $product->getTotal()], $this->products);
        return array_sum(array_column($serializeProduct, 'price')) + $this->shipping;
    }
}
