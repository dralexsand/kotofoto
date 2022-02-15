<?php

use App\Http\Controllers\Api\v1\PriceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('check.auth.key')->prefix('prices')->name('prices.')->group(function () {
    Route::post('/', [PriceController::class, 'setPrices'])->name('set');
});




