<?php


use App\Models\Order as ModelOrder;
use App\Models\OrderPayment as ModelOrderPayment;
use App\Models\OrderProduct as ModelOrderProduct;
use App\Models\Product;
use App\Repositories\OrderRepository;
use Domain\Enums\OrderPaymentTypeEnum;
use Domain\Order;
use Domain\OrderPayment;
use Domain\OrderProduct;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

describe('OrderRepository Feature Test', function () {
    test("should be able create an order with all relationship", function () {
        $product = Product::factory()->create();

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
                type: OrderPaymentTypeEnum::BILLING,
                value: null,
                creditCard: null
            )
        );

        $repository = new OrderRepository(new ModelOrder(), new Product());
        $response = $repository->create($order);
        assertDatabaseCount(ModelOrder::class, 1);
        assertDatabaseCount(ModelOrderProduct::class, 1);
        assertDatabaseCount(ModelOrderPayment::class, 1);

        assertDatabaseHas(ModelOrderProduct::class, [
            'product_id' => $product->id,
            'value' => $product->price_actual,
            'quantity' => 1,
            'name' => $product->name
        ]);

        assertDatabaseHas(ModelOrderPayment::class, [
            'value' => $shipping + ($product->price_actual * 1),
            'type' => 'billing',
            'order_id' => $response->id,
            'credit_card' => null,
        ]);
    });
});