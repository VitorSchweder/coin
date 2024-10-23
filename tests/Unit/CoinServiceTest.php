<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CoinService;
use App\Repositories\Contracts\CoinRepositoryInterface;
use Mockery;

class CoinServiceTest extends TestCase
{
    private $coinRepositoryMock;
    private $coinService;

    public function setUp(): void
    {
        parent::setUp();

        $this->coinRepositoryMock = Mockery::mock(CoinRepositoryInterface::class);
        
        $this->coinService = new CoinService($this->coinRepositoryMock);
    }

    /** @test */
    public function it_returns_recent_prices_for_a_given_symbol()
    {
        $symbol = 'BTC';
        $expectedResponse = [
            ['symbol' => 'BTC', 'price' => 50000, 'timestamp' => now()->toIso8601String()],
        ];

        $this->coinRepositoryMock
            ->shouldReceive('getRecentPrices')
            ->with($symbol)
            ->andReturn($expectedResponse);

        $result = $this->coinService->recentPrices($symbol);

        $this->assertEquals($expectedResponse, $result);
    }

    /** @test */
    public function it_returns_estimated_prices_for_a_given_date_and_symbol()
    {
        $symbol = 'BTC';
        $date = '2024-10-21T02:52:25.435Z';
        $expectedResponse = [
            'estimated_price' => 51000,
            'date' => $date,
            'symbol' => $symbol,
        ];

        $this->coinRepositoryMock
            ->shouldReceive('getEstimatedPrices')
            ->with($date, $symbol)
            ->andReturn($expectedResponse);

        $result = $this->coinService->estimatedPrices($date, $symbol);

        $this->assertEquals($expectedResponse, $result);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
