<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Exception;
use App\Models\Coin;

class CoinImportService
{
    protected $client;

    const TYPES = [
        'BTC', 
        'BCH',
        'LTC', 
        'ETH', 
        'DACXI', 
        'LINK', 
        'USDT', 
        'XLM', 
        'DOT', 
        'ADA', 
        'SOL', 
        'AVAX', 
        'LUNC',
        'MATIC', 
        'USDC', 
        'BNB', 
        'XRP', 
        'UNI', 
        'MKR', 
        'BAT', 
        'SAND',
        'EOS',
    ];

    public function __construct()
    {
        $this->client = new Client();
    }

    public function importCoins($page = 1)
    {
        try {
            $response = $this->createRequest($page);

            if (! empty($response)) {
                foreach ($response as $data) {  
                    $dateTime = Carbon::parse($data['last_updated']);
                    $lastUpdated = $dateTime->toDateTimeString();

                    $symbol = mb_strtoupper($data['symbol']);
                    if (! in_array($symbol, self::TYPES)) {
                        continue;
                    }

                    $totalCoin = Coin::where('name', $data['name'])
                        ->where('last_updated', $lastUpdated)
                        ->count();

                    if ($totalCoin == 0) {
                        Coin::create([
                            'name' => $data['name'],
                            'symbol' => $symbol,
                            'current_price' => $this->numberToDecimal($data['current_price']),
                            'last_updated' => $lastUpdated
                        ]);
                    }
                }

                sleep(5);

                $this->importCoins($page + 1);
            }
        } catch (Exception $e) {
            Log::error('Import failed: ' . $e->getMessage());
        }
    }

    public function createRequest($page)
    {
        $data = $this->makeRequest($page);

        if (isset($data['error'])) {
            throw new Exception($data['message']);
        }

        return $data;
    }

    public function makeRequest($page)
    {
        $requestParams =[
            'headers' => [
                'Content-Type' => 'application/json',
                'x-cg-demo-api-key' => config('app.coin_api.key')
            ], 
        ];

        try {
            $response = $this->client->get(
                config('app.coin_api.url').'/coins/markets?vs_currency=usd&per_page=250&page='.$page, 
                $requestParams
            );

            $response = $response->getBody()->getContents();

            return json_decode($response, true);
        } catch (Exception $exception) {
            return [
                'error' => true,
                'message' => $exception->getMessage(),
            ];
        }
    }

    private function numberToDecimal($number)
    {
       $floatValue = (float) $number;
   
       $decimalValue = sprintf('%.20f', $floatValue);
   
       return rtrim(rtrim($decimalValue, '0'), '.');
    }
}