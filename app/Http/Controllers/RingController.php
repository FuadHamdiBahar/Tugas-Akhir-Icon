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
        $data['date'] = date('F', strtotime(date('d-m-Y')));
        $data['month'] = $month;

        $sbu_ref = array(
            'sumbagut' => 'Sumatra Bagian Utara',
            'sumbagsel' => 'Sumatra Bagian Selatan',
            'sumbagteng' => 'Sumatra Bagian Tengah',
            'jakarta' => 'Jakarta',
            'jabar' => 'Jawa Barat',
            'jateng' => 'Jawa Tengah',
            'jatim' => 'Jawa Timur',
            'balnus' => 'Bali Nusa',
            'kal' => 'Kalimantan',
            'ibt' => 'Sulawesi',
        );
        $data['sbu_name'] = $sbu_ref[$sbu];
        $data['sbu'] = $sbu;
        return view('ring', $data);
    }
}
