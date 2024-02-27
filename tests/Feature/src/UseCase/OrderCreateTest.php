<?php


use App\Models\Product;
use Domain\Events\OrderCreateEvent;
use Domain\Exceptions\OrderNoItemException;
use Illuminate\Support\Facades\Event;
use UseCase\DTO\OrderOutput;
use UseCase\Exceptions\OrderCreateException;
use UseCase\OrderCreate;

use function PHPUnit\Framework\assertInstanceOf;

describe('OrderCreate Feature Test', function () {
    beforeEach(fn () => $this->useCase = app(OrderCreate::class));

    test("exception -> creating a order without products and payments", function () {
        expect(fn () => $this->useCase->execute(
            customer: 'customer',
            address: 'address',
            shipping: 100,
        ))->toThrow(new OrderCreateException("Products or payments not informed"));
    });

    test("exception -> creating a order without products", function () {
        expect(fn () => $this->useCase->addPayment(
            type: 'billing'
        )->execute(
            customer: 'customer',
            address: 'address',
            shipping: 100,
        ))->toThrow(new OrderNoItemException());
    });

    test("exception -> creating a order without payments", function () {
        $product = Product::factory()->create();

        expect(fn () => $this->useCase->addProduct(
            id: $product->id,
            quantity: 1
        )->execute(
            customer: 'customer',
            address: 'address',
            shipping: 100,
        ))->toThrow(new OrderCreateException("Products or payments not informed"));
    });

    test("creating a new order", function () {
        Event::fake();

        $product = Product::factory()->create();

        $response = $this->useCase->addProduct(
            id: $product->id,
            quantity: 1
        )->addPayment(
            type: 'billing'
        )->execute(
            customer: 'customer',
            address: 'address',
            shipping: 100,
        );

        assertInstanceOf(OrderOutput::class, $response);

        Event::assertDispatched(OrderCreateEvent::class, function ($event) use ($response) {
            return ['id' => $response->id] === $event->payload();
        });
    });
});
