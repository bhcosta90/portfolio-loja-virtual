<?php

declare(strict_types=1);

namespace Domain;

use Domain\Enum\OrderPaymentTypeEnum;

class OrderPayment
{
    public function __construct(
        public OrderPaymentTypeEnum $type,
        public int $value,
    ) {
        //
    }
}
