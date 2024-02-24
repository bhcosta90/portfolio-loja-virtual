<?php

declare(strict_types=1);

namespace Domain;

class OrderProduct
{
    public function __construct(
        protected string $id,
        protected string $name,
        protected int $value,
        protected int $quantity,
    ) {
        //
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getTotal(): int
    {
        return $this->value * $this->quantity;
    }
}
