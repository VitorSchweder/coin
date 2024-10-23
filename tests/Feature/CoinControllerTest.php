<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Coin;
use App\Services\CoinService;
use Mockery;

class CoinControllerTest extends TestCase
{
    use RefreshDatabase;

    private $coinService;

    public function setUp(): void
    {
        parent::setUp();

        $this->coinService = Mockery::mock(CoinService::class);
        
        $this->app->instance(CoinService::class, $this->coinService);      
    }

    /** @test */
    public function it_returns_recent_prices()
    {
        $symbol = 'BTC';
        $expectedResponse = [
            'prices' => [
                ['symbol' => 'BTC', 'price' => 50000, 'timestamp' => now()->toIso8601String()]
            ]
        ];

        $this->coinService
            ->shouldReceive('recentPrices')
            ->with($symbol)
            ->andReturn($expectedResponse);

        $response = $this->getJson(route('api.recent.prices', ['symbol' => $symbol]));

        $response->assertStatus(200)
                 ->assertJson($expectedResponse);
    }

    /** @test */
    public function it_returns_estimated_prices()
    {
        $symbol = 'BTC';
        $date = '2024-10-21T02:52:25.435Z';
        
        $expectedResponse = [
            'estimated_price' => 51000,
            'date' => $date,
            'symbol' => $symbol
        ];

        $this->coinService
            ->shouldReceive('estimatedPrices')
            ->with($date, $symbol)
            ->andReturn($expectedResponse);

        $response = $this->getJson(route('api.estimated.prices', [
            'symbol' => $symbol,
            'date' => $date
        ]));

        $response->assertStatus(200)
                 ->assertJson($expectedResponse);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
