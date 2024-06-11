<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RingController extends Controller
{
    public static function convertNumToTextMonth()
    {
        $m = (int) date('m');
        $listMonthName = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
        return $listMonthName[$m - 1];
    }

    public function ring($sbu)
    {
        $month = self::convertNumToTextMonth();
        $data = ApiController::listOfMaxTrafficEachRing($sbu, $month);
        $data['image'] = $sbu . '.png';
        return view('ring', $data);
    }
}
