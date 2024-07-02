<?php

namespace App\Http\Controllers;

use App\Models\TrendModel;

class TrendController extends Controller
{
    public function index($sbu)
    {

        // $listMonthName = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul'];
        $listMonthName = ['jul'];
        foreach ($listMonthName as $m) {
            $data = ApiController::listOfMaxTrafficEachRing($sbu, $m);
            // return $data;
            foreach ($data as $d) {
                TrendModel::createTrend($sbu, $m, '2024', $d['name'], $d['data']);
            }
        }
        $out['message'] = 'Data have been created';
        return $out;
    }

    public function update($sbu)
    {
        // return $sbu;
        $m = RingController::convertNumToTextMonth();
        $data = ApiController::listOfMaxTrafficEachRing($sbu, $m);

        foreach ($data as $ring) {
            TrendModel::updateTrend($sbu, $m, $ring['name'], $ring['data']);
        }
        $out['message'] = 'Data have been updated';
        return $out;
    }
}
