<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ImportCoinData;

class ImportCoins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coins:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import coins from API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ImportCoinData::dispatch();        
    }
}
