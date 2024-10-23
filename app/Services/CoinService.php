<?php

namespace App\Services;

use App\Repositories\Contracts\CoinRepositoryInterface;

class CoinService
{
    private $coinRepository;

    public function __construct(CoinRepositoryInterface $coinRepository)
    {
        $this->coinRepository = $coinRepository;
    }

    public function recentPrices($symbol)
    {    
        return $this->coinRepository->getRecentPrices($symbol);
    }

    public function estimatedPrices($date, $symbol)
    {    
        return $this->coinRepository->getEstimatedPrices($date, $symbol);
    }
}
