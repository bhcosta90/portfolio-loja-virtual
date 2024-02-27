<?php


use App\Models\Order as ModelOrder;
use App\Models\OrderPayment as ModelOrderPayment;
use App\Models\OrderProduct as ModelOrderProduct;
use App\Models\Product as ModelProduct;
use App\Repositories\OrderRepository;
use Domain\Enums\OrderPaymentTypeEnum;
use Domain\Order;
use Domain\OrderPayment;
use Domain\OrderProduct;
use Domain\ValueObjects\CreditCard;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotEmpty;

describe('OrderRepository Feature Test', function () {
    test("should be able create an order with all relationship", function () {
        $product = ModelProduct::factory()->create();

        $order = new Order(
            customer: 'testing',
            address: 'address',
            shipping: $shipping = 10,
        );

        $order->addProduct(
            new OrderProduct(
                id: $product->id,
                name: $product->name,
                value: $product->price_actual,
                quantity: 1
            )
        );

        $order->addPayment(
            new OrderPayment(
                type: OrderPaymentTypeEnum::CREDIT_CARD,
                value: null,
                creditCard: new CreditCard(
                    name: 'testing-name',
                    number: 'testing-number',
                    month: date('m'),
                    year: date('Y'),
                    cvc: 'cvc',
                )
            )
        );

        $repository = new OrderRepository(new ModelOrder(), new ModelProduct());
        $response = $repository->create($order);

        assertDatabaseCount(ModelOrder::class, 1);
        assertDatabaseCount(ModelOrderProduct::class, 1);
        assertDatabaseCount(ModelOrderPayment::class, 1);

        assertDatabaseHas(ModelOrderProduct::class, [
            'order_id' => $response->id,
            'product_id' => $product->id,
            'value' => $product->price_actual,
            'quantity' => 1,
            'name' => $product->name
        ]);

        assertDatabaseHas(ModelOrderPayment::class, [
            'order_id' => $response->id,
            'value' => $shipping + ($product->price_actual * 1),
            'type' => 'credit-card',
        ]);

        assertNotEmpty(ModelOrderPayment::first()->credit_card);

        assertEquals([
            'name' => 'testing-name',
            'number' => 'testing-number',
            'month' => '02',
            'year' => '2024',
            'cvc' => 'cvc',
        ], CreditCard::decrypt(ModelOrderPayment::first()->credit_card));
    });
});
