<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\CoinImportService;
use Illuminate\Support\Facades\Log;

class ImportCoinData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $service = new CoinImportService;
            
            $data = $service->importCoins();

            Log::info('Request successful: Imported Coin data from API, date:' . date('d/m/Y H:i:s'));
        } catch (Exception $e) {
            Log::error('Request failed: ' . $e->getMessage());
        }
    }
}
