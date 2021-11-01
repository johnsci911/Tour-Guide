<?php

use App\Http\Controllers\Api\VenueController as VenueController;
use App\Http\Controllers\Api\WeatherController;
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

Route::get('/weather', [WeatherController::class, 'index'])->name('weather.index');
Route::get('/venue', [VenueController::class, 'index'])->name('four.index');
