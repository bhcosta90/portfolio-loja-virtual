<?php


use Domain\Exceptions\OrderNoItemException;
use UseCase\Exceptions\OrderCreateException;
use UseCase\OrderCreate;

describe('OrderCreate Feature Test', function () {
    beforeEach(fn () => $this->useCase = app(OrderCreate::class));

    test("creating a order without products and payments", function () {
        expect(fn () => $this->useCase->execute(
            customer: 'customer',
            address: 'address',
            shipping: 100,
        ))->toThrow(new OrderCreateException("Products or payments not informed"));
    });

    test("creating a order without products", function () {
        expect(fn () => $this->useCase->addPayment(
            type: 'billing'
        )->execute(
            customer: 'customer',
            address: 'address',
            shipping: 100,
        ))->toThrow(new OrderNoItemException());
    });

    test("creating a order without payments", function () {
        expect(fn () => $this->useCase->addProduct(
            id: 'testing',
            name: 'name',
            value: 10,
            quantity: 1
        )->execute(
            customer: 'customer',
            address: 'address',
            shipping: 100,
        ))->toThrow(new OrderCreateException("Products or payments not informed"));
    });
});
