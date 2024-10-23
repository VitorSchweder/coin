<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Services\CoinService;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    private $coinService;

    public function __construct(CoinService $coinService)
    {
       $this->coinService = $coinService;
    }

    public function recentPrices(Request $request)
    {       
        $symbol = $request->get('symbol', null);

        return response()->json($this->coinService->recentPrices($symbol));
    }

    public function estimatedPrices(Request $request)
    {       
        $symbol = $request->get('symbol', null);
        $date = $request->get('date', null);

        return response()->json($this->coinService->estimatedPrices($date, $symbol));
    }
}