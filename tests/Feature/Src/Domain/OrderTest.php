<?php

use Domain\Enum\OrderPaymentTypeEnum;
use Domain\Order;
use Domain\OrderNoItemException;
use Domain\OrderPayment;
use Domain\OrderProduct;

describe('OrderTest Feature Test', function () {
    test('creating a simple order with no payment and no items', function () {
        $order = new Order(
            customer: 'customer',
            address: 'address',
            shipping: 10,
        );

        expect('customer')
            ->toBe($order->getCustomer())
            ->and('address')->toBe($order->getAddress())
            ->and(10)->toBe($order->getShipping())
            ->and(10)->toBe($order->getTotal());
    });

    test('creating an order with 3 product items', function () {
        $order = new Order(
            customer: 'customer',
            address: 'address',
            shipping: 10,
        );

        $product_01 = new OrderProduct(id: 'id', name: 'testing', value: 100, quantity: 1);
        $product_02 = new OrderProduct(id: 'id', name: 'testing', value: 130, quantity: 2);
        $product_03 = new OrderProduct(id: 'id', name: 'testing', value: 120, quantity: 5);

        $order->addProduct($product_01);
        $order->addProduct($product_02);
        $order->addProduct($product_03);

        expect(970)->toBe($order->getTotal());
    });


    test('creating an order with no items but sending payment', function () {
        $order = new Order(
            customer: 'customer',
            address: 'address',
            shipping: 10,
        );

        expect(fn() => $order->addPayment(new OrderPayment(type: OrderPaymentTypeEnum::BILLING, value: null, creditCard: null)))->toThrow(new OrderNoItemException());
    });
});
