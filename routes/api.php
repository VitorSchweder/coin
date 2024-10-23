<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'coins',
], function () {
    Route::get('/recent-prices', 'CoinController@recentPrices')->name('api.recent.prices');
    Route::get('/estimated-prices', 'CoinController@estimatedPrices')->name('api.estimated.prices');
});
