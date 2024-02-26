<?php

declare(strict_types=1);

namespace App\Implementations;

use Closure;
use Contracts\DatabaseInterface;
use Illuminate\Support\Facades\DB;

class Database implements DatabaseInterface
{
    public function transaction(Closure $closure)
    {
        return DB::transaction($closure);
    }
}
