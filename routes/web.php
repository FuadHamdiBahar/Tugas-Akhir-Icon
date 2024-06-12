<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RingController;
use App\Http\Controllers\TrendController;
use App\Http\Controllers\UtilisationController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

Route::get('/', [DashboardController::class, 'dashboard']);
Route::prefix('/utilisation')->group(function () {
    Route::get('/{sbu}', [UtilisationController::class, 'utilisation'])->name('utilisation');
});
Route::prefix('/ring')->group(function () {
    Route::get('/{sbu}', [RingController::class, 'ring'])->name('ring');
});


// myApi
Route::prefix('/api')->group(function () {
    Route::get('/trend/{sbu}', [ApiController::class, 'ringTrend']);
    Route::get('/summary/{sbu}/{month}', [ApiController::class, 'listOfMaxTrafficEachRing']);
});
// Route::get('/utilisation', [UtilisationController::class, 'utilisation']);

// Route::get('/ring/{sbu}', [ApiController::class, 'listOfMaxTrafficEachRing']);
// Route::get('/max', [ApiController::class, 'listOfMaxTrafficEachSourceToDestination']);
// Route::get('/list/{origin}/{terminating}/{start}/{end}', [ApiController::class, 'listTraffic']);


// mytestroute
Route::get('/tes/{sbu}', [ApiController::class, 'listOfMaxTrafficEachRing']);
Route::get('/createtrend/{sbu}', [TrendController::class, 'index']);
