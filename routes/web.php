<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PolygonController;
use App\Http\Controllers\PsSarpenController;
use App\Http\Controllers\RingController;
use App\Http\Controllers\UtilisationController;
use App\Models\PSSarpen;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('is_admin');

    Route::get('/utilization/{sbu}', [UtilisationController::class, 'utilisation'])->name('utilization')->middleware('is_admin');

    Route::get('/{sbu}/ring/{ring}', [UtilisationController::class, 'ringUtilisation'])->name('ringUtilisation')->middleware('is_admin');

    Route::get('/device/{origin}/{terminating}', [DeviceController::class, 'index'])->name('device')->middleware('is_admin');

    Route::get('/summary/{sbu}', [RingController::class, 'ring'])->name('summary')->middleware('is_admin');

    Route::get('/documentation', [DashboardController::class, 'documentation'])->name('documentation');

    Route::prefix('/master')->group(function () {
        Route::get('/hosts', [MasterController::class, 'master'])->name('master')->middleware('is_superadmin');

        Route::get('/markers', [MarkerController::class, 'list'])->name('marker')->middleware('is_superadmin');

        Route::get('/markers/{markerid}', [MarkerController::class, 'detail'])->name('markerDetail')->middleware('is_superadmin');

        Route::get('/polygons', [PolygonController::class, 'list'])->name('polygon')->middleware('is_superadmin');

        Route::get('/polygons/{polygonid}', [PolygonController::class, 'detail'])->name('polygonDetail')->middleware('is_superadmin');
    });

    Route::get('/interface/{hostid}', [MasterController::class, 'interface'])->name('interface')->middleware('is_admin');

    Route::get('/improvement/pssarpen', [PsSarpenController::class, 'index'])->middleware('is_admin');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/signin', [AuthController::class, 'signin'])->name('login');
    Route::post('/signin', [AuthController::class, 'submitSignin'])->name('login.submit');
});

Route::middleware('auth')->group(function () {
    // myApi
    Route::prefix('/api')->group(function () {
        Route::get('/trend/{sbu}', [ApiController::class, 'ringTrend']);
        Route::get('/weekly/{sbu}', [ApiController::class, 'weeklyTrend']);
        Route::get('/list/{sbu}', [ApiController::class, 'listOfMaxTrafficEachRing']);
        Route::get('/summary/{sbu}', [ApiController::class, 'sumOfMaxTrafficEachRing']);
        Route::get('/link/{sbu}', [ApiController::class, 'ringLink']);
        Route::get('/trendmonth/{origin}/{terminating}', [ApiController::class, 'listTrafficMonth']);
        Route::get('/trendweek/{origin}/{terminating}', [ApiController::class, 'listTrafficWeek']);

        Route::get('/host', [ApiController::class, 'retrieveHost']);
        Route::get('/host/{host}', [ApiController::class, 'retrieveSingleHost'])->name('host.get');
        Route::post('/host', [ApiController::class, 'createHost']);
        Route::put('/host', [ApiController::class, 'updateHost']);
        Route::delete('/host/{hostid}', [ApiController::class, 'deleteHost']);

        Route::get('/interface/{hostid}', [ApiController::class, 'retrieveInterface'])->name('hostname.interface');
        Route::get('/interface/detail/{interfaceid}', [ApiController::class, 'retrieveSingleInterface']);
        Route::post('/interface', [ApiController::class, 'createInterface']);
        Route::put('/interface', [ApiController::class, 'updateInterface']);
        Route::delete('/interface/{interfaceid}', [ApiController::class, 'deleteInterface']);

        Route::get('/marker', [ApiController::class, 'retrieveMarker']);
        Route::get('/marker/{markerid}', [ApiController::class, 'retrieveSingleMarker']);
        Route::post('/marker', [ApiController::class, 'createMarker']);
        Route::put('/marker', [ApiController::class, 'updateMarker']);
        Route::delete('/marker/{markerid}', [ApiController::class, 'deleteMarker']);

        Route::get('/polygon', [ApiController::class, 'retrievePolygon']);
        Route::get('/polygon/{polygonid}', [ApiController::class, 'retrieveSinglePolygon']);
        Route::post('/polygon', [ApiController::class, 'createPolygon']);
        Route::put('/polygon', [ApiController::class, 'updatePolygon']);
        Route::delete('/polygon/{polygonid}', [ApiController::class, 'deletePolygon']);

        Route::get('/point/{pointid}', [ApiController::class, 'retrieveSinglePoint']);
        Route::post('/point', [ApiController::class, 'createPoint']);
        Route::put('/point', [ApiController::class, 'updatePoint']);
        Route::delete('/point/{pointid}', [ApiController::class, 'deletePoint']);

        Route::get('/sbumarker/{sbu}', [ApiController::class, 'sbuMarker'])->name('sbuMarker');

        Route::get('/sbupolygon/{sbu}', [ApiController::class, 'sbuPolygon'])->name('retrievePolygon');

        // Route::put('/master', [ApiController::class, 'updateMaster']);
        // Route::get('/master', [ApiController::class, 'getMaster']);
        // Route::get('/master/{hid}/{iid}', [ApiController::class, 'getSingleMaster']);

        Route::get('/top', [ApiController::class, 'top']);
        Route::get('/topSbu', [ApiController::class, 'topEachSBU']);
        Route::get('/topMonth', [ApiController::class, 'topEachMonth']);
        Route::get('/diff', [ApiController::class, 'monthDifference']);
        Route::get('/totalUtilization/{year}/{month}', [ApiController::class, 'totalUtilization']);
        Route::get('/totalUtilization/{year}', [ApiController::class, 'totalUtilizationEachMonth']);
        Route::get('/localUtilization/{sbu_name}', [ApiController::class, 'localUtilization']);

        // PS Sarpen
        Route::get('/pssarpen', [ApiController::class, 'pssarpen'])->name('pssarpen.get');
        Route::get('/pssarpen/marker', [ApiController::class, 'pssarpenMarker']);
    });
});

Route::get('/makeuser', function () {
    return User::create(
        [
            'name' => 'Heru Kismanto',
            'email' => 'heru.kismanto@iconpln.co.id',
            'password' => bcrypt('h3ruK!smanto'),
        ]
    );
});

Route::get('/phpinfo', function () {
    phpinfo();
})->name('phpinfo');
