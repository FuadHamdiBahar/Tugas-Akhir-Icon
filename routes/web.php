<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RingController;
use App\Http\Controllers\UtilisationController;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

Route::get('/', [DashboardController::class, 'dashboard']);
Route::prefix('/utilisation')->group(function () {
    Route::get('/{sbu}', [UtilisationController::class, 'utilisation'])->name('utilisation');
});
Route::prefix('/ring')->group(function () {
    Route::get('/{sbu}', [RingController::class, 'ring'])->name('ring');
});
// Route::get('/utilisation', [UtilisationController::class, 'utilisation']);

// myApi
// Route::get('/ring/{sbu}', [ApiController::class, 'listOfMaxTrafficEachRing']);
// Route::get('/max', [ApiController::class, 'listOfMaxTrafficEachSourceToDestination']);
// Route::get('/list/{origin}/{terminating}/{start}/{end}', [ApiController::class, 'listTraffic']);

// mytestroute
Route::get('/tes', function () {
    $path = public_path('data utilisasi.xlsx');
    $reader = new Xlsx();
    $spreadsheet = $reader->load($path);
    $sheet = $spreadsheet->getSheetByName('01. SBU_Apr24_ok');
    $totalRows = $sheet->getHighestRow();

    for ($row = 4; $row <= $totalRows; $row++) {
        var_dump($sheet->getCell("E{$row}")->getValue());
        var_dump($sheet->getCell("F{$row}")->getValue());
        var_dump($sheet->getCell("H{$row}")->getValue());
        var_dump($sheet->getCell("I{$row}")->getValue());
    }
});
