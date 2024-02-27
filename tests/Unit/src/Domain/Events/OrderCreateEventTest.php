<?php

use Domain\Events\OrderCreateEvent;
use Domain\Order;

use function PHPUnit\Framework\assertEquals;

test('OrderCreateEvent Unit Test', function () {
    $order = Mockery::mock(Order::class);
    $order->shouldReceive('getId')->andReturn('testing');

    $event = new OrderCreateEvent(order: $order);
    assertEquals([
        'id' => 'testing',
    ], $event->payload());
});
