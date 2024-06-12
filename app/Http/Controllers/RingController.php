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
        $data['image'] = $sbu . '.png';
        $data['date'] = date('d-m-Y');
        $data['sbu_name'] = ucfirst($sbu);
        return view('ring', $data);
    }
}
