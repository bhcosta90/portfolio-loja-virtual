<?php

declare(strict_types=1);

namespace App\Implementations;

use Contracts\EventInterface;
use Contracts\EventManagerInterface;

use function event;

class EventManager implements EventManagerInterface
{
    public function dispatch(EventInterface $event): void
    {
        event($event);
    }
}
