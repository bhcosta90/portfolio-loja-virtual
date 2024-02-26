<?php

namespace App\Providers;

use App\Implementations\Database;
use App\Implementations\EventManager;
use App\Repositories\OrderRepository;
use Contracts\DatabaseInterface;
use Contracts\EventManagerInterface;
use Domain\Repository\OrderRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(DatabaseInterface::class, Database::class);
        $this->app->bind(EventManagerInterface::class, EventManager::class);
    }

    public function boot(): void
    {
        //
    }
}
