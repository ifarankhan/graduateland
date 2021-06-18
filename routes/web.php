<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Scraper\ScraperController;

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

//Scrap data view
Route::get(
    '/',
    [ScraperController::class, 'index']
)->name('home');

//Scrap data view
Route::post(
    '/scraper',
    [ScraperController::class, 'scraper']
)->name('scraper');

