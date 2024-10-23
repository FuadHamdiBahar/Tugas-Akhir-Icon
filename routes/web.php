<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\RingController;
use App\Http\Controllers\TrendController;
use App\Http\Controllers\UtilisationController;
use App\Models\Host;
use App\Models\Marker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/utilization/{sbu}', [UtilisationController::class, 'utilisation'])->name('utilization');

    Route::get('/{sbu}/ring/{ring}', [UtilisationController::class, 'ringUtilisation'])->name('ringUtilisation');

    Route::get('/device/{origin}/{terminating}', [DeviceController::class, 'index'])->name('device');

    Route::get('/summary/{sbu}', [RingController::class, 'ring'])->name('summary');

    Route::get('/documentation', [DashboardController::class, 'documentation'])->name('documentation');

    Route::get('/master', [MasterController::class, 'master'])->name('master')->middleware('is_admin');

    Route::get('/interface/{hostid}', [MasterController::class, 'interface'])->name('interface')->middleware('is_admin');

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
        Route::get('/host/{host}', [ApiController::class, 'retrieveSingleHost']);
        Route::put('/host', [ApiController::class, 'updateHost']);
        Route::post('/host', [ApiController::class, 'createHost']);
        Route::delete('/host/{hostid}', [ApiController::class, 'deleteHost']);

        Route::get('/interface/{hostid}', [ApiController::class, 'retrieveInterface']);
        Route::get('/interface/detail/{interfaceid}', [ApiController::class, 'retrieveSingleInterface']);
        Route::post('/interface', [ApiController::class, 'createInterface']);
        Route::put('/interface', [ApiController::class, 'updateInterface']);
        Route::delete('/interface/{interfaceid}', [ApiController::class, 'deleteInterface']);

        Route::get('/marker/{sbu}', [ApiController::class, 'retrieveMarker'])->name('retrieveMarker');

        Route::get('/polygon/{sbu}', [ApiController::class, 'retrievePolygon'])->name('retrievePolygon');

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
    });
});

use PhpOffice\PhpSpreadsheet\IOFactory;
use Ramsey\Uuid\Uuid;

// Gunakan route ini untuk pairing pop dengan perangkat
// Route::get('/pairing', function () {
//     $reader = IOFactory::createReader("Xlsx");
//     $spreadsheet = $reader->load("D:\Code\myapp\public\marker host.xlsx");
//     $sheet = $spreadsheet->getSheetByName('02. Router 100G sd 2022rev6');

//     // mendapatkan jumlah baris
//     $totalRows = $sheet->getHighestRow();
//     // $totalRows = 10;

//     $myLokasi = [];
//     for ($row = 2; $row <= $totalRows; $row++) {
//         $lokasi = $sheet->getCell("H{$row}")->getValue();
//         $pop = $sheet->getCell("I{$row}")->getValue();

//         $hosts = Host::where('host_name', 'LIKE', "%$lokasi%")->get();

//         $marker = Marker::where('marker_name', 'LIKE', "%$pop%")->first();


//         if (count($hosts) > 0) {
//             foreach ($hosts as $h) {
//                 $myuuid = Uuid::uuid4()->toString();
//                 DB::select("INSERT INTO marker_hosts (mhid, markerid, hostid) VALUES ('$myuuid', '$marker->markerid', $h->hostid)");
//             }
//             array_push($myLokasi, $hosts);
//         }
//         // return $lokasi;
//     }

//     return $myLokasi;
//     // $sql = "SELECT * FROM hosts WHERE sbu_name = '$sbu'";
//     // echo 'Fuad Hamdi Bahar';
// });

// Route::get('/tes', function () {
//     return bcrypt('Adm1n!c0n');
// });

// Route::get('/map', [MapController::class, 'index']);
