<?php


use Domain\OrderProduct;

use function PHPUnit\Framework\assertEquals;

test('OrderProductTest Feature Test', function () {
    $product = new OrderProduct(id: 'testing-id', name: 'testing-name', value: 120, quantity: 3);

    assertEquals('testing-id', $product->getId());
    assertEquals('testing-name', $product->getName());
    assertEquals(120, $product->getValue());
    assertEquals(3, $product->getQuantity());
    assertEquals(360, $product->getTotal());
});
