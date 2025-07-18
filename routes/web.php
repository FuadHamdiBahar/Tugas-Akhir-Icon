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


// Gunakan route ini untuk pairing pop dengan perangkat
// use PhpOffice\PhpSpreadsheet\IOFactory;
// use Ramsey\Uuid\Uuid;
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


// untuk menambahkan hostname terminating dari excel
// Route::get('/addhosterm', function () {
//     ini_set('max_execution_time', 600);
//     function insertInterface($hostid, $interface_name, $description, $capacity, $status)
//     {
//         $sql = "INSERT INTO interfaces (hostid, interface_name, description, capacity, status) VALUES ($hostid, '$interface_name', '$description', $capacity, $status)";
//         DB::select($sql);
//     }

//     $sbu_name = array('sumbagut', 'sumbagteng', 'sumbagsel', 'jakarta', 'jabar', 'jateng', 'jatim', 'balnus', 'kalimantan', 'sulawesi');

//     foreach ($sbu_name as $sbu) {
//         $path = public_path('data utilisasi.xlsx');
//         $reader = new Xlsx();
//         $spreadsheet = $reader->load($path);
//         $sheet = $spreadsheet->getSheetByName($sbu);
//         $totalRows = $sheet->getHighestRow();

//         // new array to merge
//         $merge = array();

//         for ($row = 2; $row <= $totalRows; $row++) {
//             if (!empty($sheet->getCell("B{$row}")->getValue())) {
//                 $ring = $sheet->getCell("A{$row}")->getValue();
//                 $org = $sheet->getCell("B{$row}")->getValue();
//                 $interface_name = $sheet->getCell("C{$row}")->getValue();
//                 $trm = $sheet->getCell("D{$row}")->getValue();
//                 $status = $sheet->getCell("E{$row}")->getValue();
//                 $capacity = $sheet->getCell("F{$row}")->getValue();

//                 if ($status != 1) {
//                     $sql = "SELECT * FROM hosts WHERE ring = $ring AND host_name = '$org'";
//                     $data = DB::select($sql);

//                     if (count($data) > 0) {
//                         #langsung insert interface
//                         insertInterface($data[0]->hostid, $interface_name, $trm, $capacity * 1000000000, 0);
//                     } else {
//                         // buat host terus buat interface
//                         $sql = "INSERT INTO hosts (sbu_name, ring, host_name) VALUES ('$sbu', $ring, '$org')";
//                         DB::select($sql);
//                         // ambil id terakhir
//                         $hostid = DB::select('SELECT max(hostid) as hostid from hosts');
//                         insertInterface($hostid[0]->hostid, $interface_name, $trm, $capacity * 1000000000, 0);
//                     }
//                 }
//             }
//         }
//     }



//     return $sbu_name;
// });

Route::get('/makepass', function () {
    return bcrypt('hari.haryono');
});
