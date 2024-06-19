<?php

namespace App\Http\Controllers;

use App\Models\TrendModel;

class TrendController extends Controller
{
    public function index($sbu)
    {

        $listMonthName = ['jan', 'feb', 'mar', 'apr', 'may', 'jun'];
        foreach ($listMonthName as $m) {
            $data = ApiController::listOfMaxTrafficEachRing($sbu, $m);
            foreach ($data['data'] as $d) {
                TrendModel::createTrend($sbu, $m, '2024', $d['ring'], $d['val']);
            }
        }
        return TRUE;
    }

    public function update($sbu)
    {
        $m = RingController::convertNumToTextMonth();
        $data = ApiController::listOfMaxTrafficEachRing($sbu, 'jan');

        foreach ($data['data'] as $ring) {
            TrendModel::updateTrend($sbu, 'jan', $ring['ring'], $ring['val']);
        }
        return TRUE;
    }
}
