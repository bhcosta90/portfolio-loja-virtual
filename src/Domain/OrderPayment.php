<?php

declare(strict_types=1);

namespace Domain;

use Domain\Enums\OrderPaymentTypeEnum;
use Domain\ValueObjects\CreditCard;

class OrderPayment
{
    protected ?bool $hasValue = null;

    public function __construct(
        protected OrderPaymentTypeEnum $type,
        protected ?int $value,
        protected ?CreditCard $creditCard,
    ) {
        $this->hasValue = (bool)$this->value;
    }

    public function getType(): OrderPaymentTypeEnum
    {
        return $this->type;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function getCreditCard(): ?string
    {
        return $this->creditCard?->getHash();
    }

    public function getHasValue(): ?bool
    {
        return $this->hasValue;
    }
}
