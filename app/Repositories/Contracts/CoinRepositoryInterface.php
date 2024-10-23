<?php

namespace App\Repositories\Contracts;

interface CoinRepositoryInterface
{   	
	public function getRecentPrices($symbol);
	public function getEstimatedPrices($date, $symbol);
}