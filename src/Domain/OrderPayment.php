<?php

declare(strict_types=1);

namespace Domain;

use Domain\Enums\OrderPaymentTypeEnum;
use Domain\Exceptions\OrderPaymentCreditCardNotFound;
use Domain\ValueObjects\CreditCard;

use function is_null;

class OrderPayment
{
    protected ?bool $hasValue = null;

    public function __construct(
        protected OrderPaymentTypeEnum $type,
        protected ?int $value,
        protected ?CreditCard $creditCard,
    ) {
        $this->hasValue = (bool)$this->value;

        if ($this->type === OrderPaymentTypeEnum::CREDIT_CARD && is_null($this->creditCard)) {
            throw new OrderPaymentCreditCardNotFound();
        }
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

    public function changeValue(int $value): void
    {
        $this->value = $value;
    }
}
