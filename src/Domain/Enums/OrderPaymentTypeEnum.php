<?php

declare(strict_types=1);

namespace Domain\Enums;

enum OrderPaymentTypeEnum: string
{
    case BILLING = 'billing';
    case CREDIT_CARD = 'credit-card';
    case PIX = 'pix';
}
