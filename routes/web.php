<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\MasterController;
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

Route::get('/master', [MasterController::class, 'master'])->name('master');

Route::get('/interface/{hostid}', [MasterController::class, 'interface'])->name('interface');


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

// run it when it needs
// Route::get('/createtrend/{sbu}', [TrendController::class, 'create']);
// Route::get('/updatetrend/{sbu}', [TrendController::class, 'update']);

Route::get('/createweeklytrend/{sbu}', [TrendController::class, 'createWeeklyTrend']);
Route::get('/updateweeklytrend/{sbu}', [TrendController::class, 'updateWeeklyTrend']);

// mytestroute
// Route::get('/tes', function () {
//     $sql = "
//     select 
//     h.hostid 
//     from myapp.hosts h 
//     where h.sbu_name = 'sumbagut' 
//     and h.ring = 'Ring 1' 
//     and h.host_name = 'SBU-GI.ACEH-NE8000.M14-NPE-02'";

//     return DB::connection('second_db')->select($sql);
// });

// will be deleted very soon
// Route::get('/createhost/{sbu}', function ($sbu) {
//     $path = public_path('ring utilisasi.xlsx');
//     $reader = new Xlsx();
//     $spreadsheet = $reader->load($path);
//     $sheet = $spreadsheet->getSheetByName($sbu);
//     $totalRows = $sheet->getHighestRow();

//     for ($row = 2; $row <= $totalRows; $row++) {
//         $sbu_name = $sbu;
//         $ring = $sheet->getCell("A{$row}")->getValue();
//         $host_name = $sheet->getCell("B{$row}")->getValue();
//         $description = $sheet->getCell("C{$row}")->getValue();
//         $interface_name = $sheet->getCell("D{$row}")->getValue();

//         // membuat host
//         $sql = "
//         insert into myapp.hosts (sbu_name, ring, host_name)
//         values ('$sbu_name', '$ring', '$host_name')";
//         DB::connection('second_db')->select($sql);

//         // mengambil hostid
//         $sql = "
//         select 
//             h.hostid 
//         from myapp.hosts h 
//         where h.sbu_name = '$sbu_name' 
//         and h.ring = '$ring' 
//         and h.host_name = '$host_name'";
//         $hostid = DB::connection('second_db')->select($sql)[0]->hostid;

//         // cek capacity
//         $capacity = cekCapacity($interface_name);

//         // membuat interface
//         $sql = "
//         insert into myapp.interfaces (hostid, interface_name, description, capacity, status)
//         values ($hostid, '$interface_name', '$description', $capacity, 1)";
//         DB::connection('second_db')->select($sql);

//         // mengambil interfaceid
//         $sql = "
//         select 
//         interfaceid
//         from myapp.interfaces i 
//         where i.interface_name = '$interface_name'
//         and i.hostid = $hostid
//         and i.description = '$description'";
//         $interfaceid = DB::connection('second_db')->select($sql)[0]->interfaceid;

//         // membuat items
//         $sql = "
//         insert into myapp.items (hostid, interfaceid)
//         values($hostid, $interfaceid)";
//         DB::connection('second_db')->select($sql);
//     }
//     return 'MENYALA';
// });

// Route::get('/createinterface/{sbu}', function ($sbu) {
// });

// function cekCapacity($interface)
// {
//     $capacity = 0;
//     if (str_contains($interface, '100GE')) {
//         $capacity =  100000000000;
//     } elseif (str_contains($interface, '50|100GE0')) {
//         $capacity =  100000000000;
//     } elseif (str_contains($interface, 'HundredGigE')) {
//         $capacity =  100000000000;
//     } elseif (str_contains($interface, 'et')) {
//         $capacity =  100000000000;
//     } elseif (str_contains($interface, 'GigabitEthernet')) {
//         $capacity =  10000000000;
//     } elseif (str_contains($interface, 'Te')) {
//         $capacity =  10000000000;
//     } elseif (str_contains($interface, 'TenGig')) {
//         $capacity =  10000000000;
//     } elseif (str_contains($interface, 'xe')) {
//         $capacity =  10000000000;
//     } elseif (str_contains($interface, 'Gi')) {
//         $capacity =  1000000000;
//     }
//     return $capacity;
// }
use Illuminate\Support\Facades\DB;

Route::get('/test', function () {
    return true;
});
