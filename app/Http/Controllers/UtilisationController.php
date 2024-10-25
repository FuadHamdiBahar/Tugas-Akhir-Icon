<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilisationController extends Controller
{
    public function utilisation($sbu)
    {
        $m = date('m');
        $month = RingController::convertNumToTextMonth($m);
        $data = ApiController::listOfMaxTrafficEachSourceToDestination($sbu, $month);
        // return $data;
        $data = array(
            'sbu' => $sbu,
            'data' => $data,
            'month' => date('F', strtotime(date('d-m-Y')))
        );
        return view('utilisation', $data);
    }

    public function ringUtilisation($sbu, $ring)
    {
        $m = date('m');
        $month = RingController::convertNumToTextMonth($m);
        $data = ApiController::listOfMaxTrafficEachSourceToDestination($sbu, $month);
        // return $ring;
        $spesific = [];
        foreach ($data['data'] as $r) {
            if ($r->ring == $ring) {
                array_push($spesific, $r);
            }
        }

        $out = [
            'data' => $spesific,
            'sbu_name' => ucfirst($sbu),
            'ring' => $ring,
            'month' => date('F', strtotime(date('d-m-Y'))),
        ];
        return view('ringUtilisation', $out);
    }
}
