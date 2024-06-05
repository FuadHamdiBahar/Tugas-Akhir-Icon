<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// myApi
Route::get('/list', [ApiController::class, 'listTraffic']);
Route::get('/max', [ApiController::class, 'listOfMaxTrafficEachSourceToDestination']);
