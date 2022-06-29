<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Cache\AllClearController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\PostPageController;
use App\Http\Controllers\Scrape\AlterScrapeController;
use App\Http\Controllers\Scrape\WhoIsScrapeController;
use App\Http\Controllers\Frontend\ContentPageController;
use App\Http\Controllers\Scrape\AlexaRankScrapeController;
use App\Http\Controllers\Scrape\DnsRecordScrapeController;
use App\Http\Controllers\Scrape\DuplicateCheckerController;
use App\Http\Controllers\Scrape\IpLocationScrapeController;
use App\Http\Controllers\Scrape\ScreenshotScrapeController;
use App\Http\Controllers\Scrape\WappalyzerScrapeController;
use App\Http\Controllers\Scrape\SeoAnalyzerScrapeController;
use App\Http\Controllers\Scrape\SslCertificateScrapeController;
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

Route::get('alter-scrape', [AlterScrapeController::class, 'alter_scrape']);
Route::get('wappalyzer-scrape', [WappalyzerScrapeController::class, 'wappalyzer_scrape']);
Route::get('ssl-scrape', [SslCertificateScrapeController::class, 'ssl_certificate_scrape']);
Route::get('alexa-scrape', [AlexaRankScrapeController::class, 'alexa_rank_scrape']);
Route::get('seo-scrape', [SeoAnalyzerScrapeController::class, 'seo_analyzer_scrape']);
Route::get('whois-scrape', [WhoIsScrapeController::class, 'who_is_scrape']);
Route::get('dns-scrape', [DnsRecordScrapeController::class, 'dns_record_scrape']);
Route::get('ip-location-scrape', [IpLocationScrapeController::class, 'ip_location_scrape']);
Route::get('screenshot-scrape', [ScreenshotScrapeController::class, 'screenshot_scrape']);

Route::get('duplicate-check', [DuplicateCheckerController::class, 'publish_duplicate']);

// Route::get('scrape', [FullScrapingController::class, 'scrape']);

Route::get('clear', [AllClearController::class, 'clear']);

Route::get('sql-update', SettingsRecordsUpdateController::class);

Route::get('test', [TestController::class, 'test']);

Route::get('/', [HomePageController::class, 'index'])->name('home.index');

Route::get('/page/{post:slug}', [ContentPageController::class, 'index'])->name('page.show');

if (Schema::hasTable('nova_settings')) {

    Route::get((!empty(nova_get_setting('permalink_prefix')) ? nova_get_setting('permalink_prefix') : "Similar") . '/{post:slug}', [PostPageController::class, 'index'])->name('post.show');
}
