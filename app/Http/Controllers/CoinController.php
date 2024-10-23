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
        $type = $request->get('type', null);

        dd($type);
       // return response()->json($this->coinService->recentPrices($type));
    }
}