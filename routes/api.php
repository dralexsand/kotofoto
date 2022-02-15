<?php

use App\Http\Controllers\Api\v1\PriceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

// ToDo check.auth.key is global?

Route::get('/test', [PriceController::class, 'test']);

Route::middleware('check.auth.key')->prefix('prices')->name('prices.')->group(function () {
    Route::post('/', [PriceController::class, 'setPrices'])->name('set');
});




