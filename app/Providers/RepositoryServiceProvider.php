<?php

namespace App\Providers;

use App\Repositories\Contracts\CoinRepositoryInterface;
use App\Repositories\CoinRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CoinRepositoryInterface::class, CoinRepository::class);
    }
}
