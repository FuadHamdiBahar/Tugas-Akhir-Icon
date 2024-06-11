<?php

namespace App\Http\Controllers;

use App\Models\TrendModel;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Shared\Trend\Trend;

class TrendController extends Controller
{
    public function index($sbu)
    {

        $listMonthName = ['jan', 'feb', 'mar', 'apr', 'may', 'jun'];
        foreach ($listMonthName as $m) {
            $data = ApiController::listOfMaxTrafficEachRing($sbu, $m);
            foreach ($data['data'] as $d) {
                TrendModel::createTrend($sbu, $m, '2024', $d['ring'], $d['val'] / 1000000000);
            }
        }
        return TRUE;
    }
}
