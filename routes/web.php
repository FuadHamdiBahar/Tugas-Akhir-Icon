<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\RingController;
use App\Http\Controllers\TrendController;
use App\Http\Controllers\UtilisationController;
use App\Models\ApiModel;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Illuminate\Support\Facades\DB;

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
    Route::get('/totalUtilization/{year}/{month}', [ApiController::class, 'totalUtilization']);
});

// run it when it needs
Route::get('/createtrend/{sbu}', [TrendController::class, 'create']);
Route::get('/updatetrend/{sbu}', [TrendController::class, 'update']);

Route::get('/createweeklytrend/{sbu}', [TrendController::class, 'createWeeklyTrend']);
Route::get('/createutil/{sbu}', function ($sbu) {
    ini_set('max_execution_time', 180);
    $months = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul'];

    foreach ($months as $month) {
        // ambil hostnya
        $sql = "
            select ring, origin, terminating from myapp.hosts h 
            where h.status = 1 and h.sbu_name = '$sbu'
        ";

        $hosts = DB::connection('second_db')->select($sql);

        // ambil trafficnya
        $merge = array();
        foreach ($hosts as $h) {
            $data = ApiModel::queryMaxTrafficEachSourceToDestination(
                $h->origin,
                $h->terminating,
                $h->ring,
                $month,

            );
            // var_dump($sheet->getCell("C{$row}")->getValue());
            array_push($merge, $data);
        }

        // flat biar gampang
        $flat = array();
        foreach ($merge as $hosts) {
            foreach ($hosts as $h) {
                $flat[] = $h;
            }
        }

        // mencari interfaces
        foreach ($flat as $f) {
            $sql = "
                select 
                    i.interfaceid 
                from myapp.hosts h 
                join myapp.interfaces i on h.hostid = i.hostid 
                where h.origin = '$f->origin'
                and h.terminating = '$f->terminating'
                and i.interface_name ='$f->interface'
                and h.sbu_name = '$sbu'";

            $interfaces =  DB::connection('second_db')->select($sql);

            // save to each interface
            foreach ($interfaces as $interface) {
                $sql = "
                    insert into myapp.utilization (interfaceid, `year`, `month`, value)
                    values ($interface->interfaceid, 2024, '$month', $f->traffic);
                ";
                DB::connection('second_db')->select($sql);
            }
        }
    }

    return 'MENYALA';
});

// mytestroute
Route::get('/tes/{sbu}', [ApiController::class, 'listOfMaxTrafficEachRing']);

// will be deleted very soon
// Route::get('/createhost/{sbu}', function ($sbu) {
//     $path = public_path('data utilisasi.xlsx');
//     $reader = new Xlsx();
//     $spreadsheet = $reader->load($path);
//     $sheet = $spreadsheet->getSheetByName($sbu);
//     $totalRows = $sheet->getHighestRow();

//     for ($row = 3; $row <= $totalRows; $row++) {
//         $sbu_name = $sbu;
//         $ring = $sheet->getCell("B{$row}")->getValue();
//         $origin = $sheet->getCell("C{$row}")->getValue();
//         $terminating = $sheet->getCell("D{$row}")->getValue();
//         $status = $sheet->getCell("E{$row}")->getValue();

//         $sql = "
//             insert into myapp.hosts (sbu_name, ring, origin, terminating, status)
//             values ('$sbu_name', '$ring', '$origin', '$terminating', $status)
//         ";
//         DB::connection('second_db')->select($sql);
//     }
//     return 'MENYALA';
// });

// Route::get('/createinterface', function () {
//     $sql = "SELECT id, origin, terminating FROM myapp.hosts";
//     $hosts = DB::connection('second_db')->select($sql);

//     foreach ($hosts as $host) {
//         $sql = "
//         select 
//             split_part(i.\"name\", '(', 1) as interface 
//         from hosts h 
//         join items i on h.hostid = i.hostid 
//         where h.name LIKE '%$host->origin%'
//         AND i.name LIKE '%$host->terminating%'
//         and i.name like '%Bits sent%'";

//         $interfaces = DB::select($sql);

//         foreach ($interfaces as $interface) {
//             $capacity = cekCapacity($interface->interface);
//             $create = "
//                 insert into myapp.interfaces (hostid, interface_name, capacity)
//                 values ($host->id, '$interface->interface', $capacity)
//             ";
//             DB::connection('second_db')->select($create);
//         }
//     }
//     return 'MENYALA';
// });

// function cekCapacity($interface)
// {
//     $capacity = 0;
//     if (str_contains($interface, 'Interface 100GE')) {
//         $capacity =  100000000000;
//     } elseif (str_contains($interface, 'Interface 50|100GE0')) {
//         $capacity =  100000000000;
//     } elseif (str_contains($interface, 'Interface HundredGigE')) {
//         $capacity =  100000000000;
//     } elseif (str_contains($interface, 'Interface et')) {
//         $capacity =  100000000000;
//     } elseif (str_contains($interface, 'Interface GigabitEthernet')) {
//         $capacity =  10000000000;
//     } elseif (str_contains($interface, 'Interface Te')) {
//         $capacity =  10000000000;
//     } elseif (str_contains($interface, 'Interface TenGig')) {
//         $capacity =  10000000000;
//     } elseif (str_contains($interface, 'Interface xe')) {
//         $capacity =  10000000000;
//     } elseif (str_contains($interface, 'Interface Gi')) {
//         $capacity =  1000000000;
//     }
//     return $capacity;
// }
