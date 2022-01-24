<?php

use App\Http\Controllers\Api\DBFeed\CsvFeederController;
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

Route::post('uploads/csv', [CsvFeederController::class, 'insert'])->name('csv_feeder');
Route::get('uploads/csv/progress-details', [CsvFeederController::class, 'getProgressDetails'])
    ->name('csv_feeder');