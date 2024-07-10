<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\RingController;
use App\Http\Controllers\TrendController;
use App\Http\Controllers\UtilisationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'dashboard']);

Route::get('/utilisation/{sbu}', [UtilisationController::class, 'utilisation'])->name('utilisation');

Route::get('/{sbu}/ring/{ring}', [UtilisationController::class, 'ringUtilisation'])->name('ringUtilisation');

Route::get('/device/{origin}/{terminating}', [DeviceController::class, 'index'])->name('device');

Route::get('/ring/{sbu}', [RingController::class, 'ring'])->name('ring');

Route::get('/documentation', [DashboardController::class, 'documentation'])->name('documentation');


// myApi
Route::prefix('/api')->group(function () {
    Route::get('/trend/{sbu}', [ApiController::class, 'ringTrend']);
    Route::get('/weekly/{sbu}', [ApiController::class, 'weeklyTrend']);
    Route::get('/list/{sbu}/{month}', [ApiController::class, 'listOfMaxTrafficEachRing']);
    Route::get('/summary/{sbu}/{month}', [ApiController::class, 'sumOfMaxTrafficEachRing']);
    Route::get('/link/{sbu}', [ApiController::class, 'ringLink']);
    Route::get('/trendmonth/{origin}/{terminating}', [ApiController::class, 'listTrafficMonth']);
    Route::get('/trendweek/{origin}/{terminating}', [ApiController::class, 'listTrafficWeek']);


    Route::get('/top', [ApiController::class, 'top']);
    Route::get('/topSbu', [ApiController::class, 'topEachSBU']);
    Route::get('/topMonth', [ApiController::class, 'topEachMonth']);
    Route::get('/diff', [ApiController::class, 'monthDifference']);
});

// run it when it needs
Route::get('/createtrend/{sbu}', [TrendController::class, 'index']);
Route::get('/updatetrend/{sbu}', [TrendController::class, 'update']);

Route::get('/createweeklytrend/{sbu}', [TrendController::class, 'createWeeklyTrend']);
// Route::get('/utilisation', [UtilisationController::class, 'utilisation']);

// Route::get('/ring/{sbu}', [ApiController::class, 'listOfMaxTrafficEachRing']);
// Route::get('/max', [ApiController::class, 'listOfMaxTrafficEachSourceToDestination']);
// Route::get('/list/{origin}/{terminating}/{start}/{end}', [ApiController::class, 'listTraffic']);


// mytestroute
Route::get('/tes/{sbu}', [ApiController::class, 'listOfMaxTrafficEachRing']);
