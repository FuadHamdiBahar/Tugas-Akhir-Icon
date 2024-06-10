<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class DashboardController extends Controller
{

    public function dashboard()
    {
        // $path = public_path('trends.xlsx');
        // $reader = new Xlsx();
        // $spreadsheet = $reader->load($path);
        // $sheet = $spreadsheet->getActiveSheet();
        // $totalRows = $sheet->getHighestRow();

        // for($row = 2; $row < $totalRows; $row++){
        //     var_dump($sheet->getCell("B{$row}")->getValue(),)
        // }

        return view('dashboard');
    }
}
