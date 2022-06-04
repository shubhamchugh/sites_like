<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Cache\AllClearController;
use App\Http\Controllers\Scrape\FullScrapingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Route::get('scrape', [FullScrapingController::class, 'scrape']);

Route::get('clear', [AllClearController::class, 'clear']);

Route::get('test', [TestController::class, 'test']);
