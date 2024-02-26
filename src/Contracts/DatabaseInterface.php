<?php

declare(strict_types=1);

namespace Contracts;

use Closure;

interface DatabaseInterface
{
    public function transaction(Closure $closure);
}
