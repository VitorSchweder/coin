<?php

namespace App\Repositories;

use App\Models\Coin;
use App\Repositories\Contracts\CoinRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CoinRepository implements CoinRepositoryInterface
{
    protected $model;

    public function __construct(Coin $coin)
    {
        $this->model = $coin;
    }

    public function getRecentPrices($symbol) 
    { 
        $query = $this->model;

        if (! empty($symbol)) {
            $symbol = $symbol ? mb_strtoupper($symbol) : null;

            $query = $query->where('symbol', $symbol);
        }
        
        $result = $query
            ->orderBy('last_updated', 'desc')
            ->get();

        return $result;
    } 

    public function getEstimatedPrices($date, $symbol) 
    { 
        $query = $this->model;

        if (! empty($symbol)) {
            $symbol = mb_strtoupper($symbol);
            $query = $query->where('symbol', $symbol);
        }

        if (! empty($date)) {
            $isValidDate = $this->validateUtcDate($date);

            if ($isValidDate) {
                $dateTime = Carbon::parse($date);
                $lastUpdated = $dateTime->toDateTimeString();

                $query = $query->where('last_updated', $lastUpdated);
            }
        }

        $result = $query
            ->orderBy('last_updated', 'desc')
            ->get();

        return $result;
    } 

    private function validateUtcDate($date) 
    {
        $pattern = '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\.\d{3}Z$/';

        // Validate format and parseable date
        return preg_match($pattern, $date) && strtotime($date) !== false;
    }
}