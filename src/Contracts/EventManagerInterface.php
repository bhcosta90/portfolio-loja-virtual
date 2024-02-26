<?php

declare(strict_types=1);

namespace Contracts;

interface EventManagerInterface
{
    public function dispatch(EventInterface $event);
}
