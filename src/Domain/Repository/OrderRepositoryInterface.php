<?php

declare(strict_types=1);

namespace Domain\Repository;

use Domain\Order;

interface OrderRepositoryInterface
{
    public function create(Order $order): Order;
}
