<?php

declare(strict_types=1);

namespace Contracts;

interface EventInterface
{
    public function payload(): array;
}
