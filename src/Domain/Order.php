<?php

declare(strict_types=1);

namespace Domain;

class Order
{
    /** @param OrderProduct[] $products */
    protected array $products;

    public function __construct(
        protected string $customer,
    ) {
        //
    }
}
