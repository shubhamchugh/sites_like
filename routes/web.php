<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Cache\AllClearController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\PostPageController;
use App\Http\Controllers\Scrape\FullScrapingController;
use App\Http\Controllers\Frontend\ContentPageController;
use App\Http\Controllers\Settings\SettingsRecordsUpdateController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('scrape', [FullScrapingController::class, 'scrape']);

Route::get('clear', [AllClearController::class, 'clear']);

Route::get('sql-update', SettingsRecordsUpdateController::class);

Route::get('test', [TestController::class, 'test']);

Route::get('/', [HomePageController::class, 'index'])->name('home.index');

Route::get('/page/{post:slug}', [ContentPageController::class, 'index'])->name('page.show');

Route::get(nova_get_setting('permalink_prefix') . '/{post:slug}', [PostPageController::class, 'index'])->name('post.show');
