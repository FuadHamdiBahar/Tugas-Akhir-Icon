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


// myApi
Route::prefix('/api')->group(function () {
    Route::get('/trend/{sbu}', [ApiController::class, 'ringTrend']);
    Route::get('/summary/{sbu}/{month}', [ApiController::class, 'listOfMaxTrafficEachRing']);
    Route::get('/link/{sbu}', [ApiController::class, 'ringLink']);
    Route::get('/trendmonth/{origin}/{terminating}', [ApiController::class, 'listTrafficMonth']);
    Route::get('/trendweek/{origin}/{terminating}', [ApiController::class, 'listTrafficWeek']);
});

// run it when it needs
Route::get('/createtrend/{sbu}', [TrendController::class, 'index']);
Route::get('/updatetrend/{sbu}', [TrendController::class, 'update']);
// Route::get('/utilisation', [UtilisationController::class, 'utilisation']);

// Route::get('/ring/{sbu}', [ApiController::class, 'listOfMaxTrafficEachRing']);
// Route::get('/max', [ApiController::class, 'listOfMaxTrafficEachSourceToDestination']);
// Route::get('/list/{origin}/{terminating}/{start}/{end}', [ApiController::class, 'listTraffic']);


// mytestroute
Route::get('/tes/{sbu}', [ApiController::class, 'listOfMaxTrafficEachRing']);
