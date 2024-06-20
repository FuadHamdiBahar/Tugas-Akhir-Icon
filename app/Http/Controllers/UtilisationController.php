<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilisationController extends Controller
{
    public function utilisation($sbu)
    {
        $month = RingController::convertNumToTextMonth();
        $data = ApiController::listOfMaxTrafficEachSourceToDestination($sbu, $month);
        // return $data;
        return view('utilisation', $data);
    }

    public function ringUtilisation($sbu, $ring)
    {
        $month = RingController::convertNumToTextMonth();
        $data = ApiController::listOfMaxTrafficEachSourceToDestination($sbu, $month);
        // return $ring;
        $spesific = [];
        foreach ($data['data'] as $r) {
            if ($r->ring == $ring) {
                array_push($spesific, $r);
            }
        }

        $out = array(
            'data' => $spesific,
            'sbu_name' => ucfirst($sbu),
            'ring' => $ring,
            'month' => date('F', strtotime(date('d-m-Y')))
        );
        return view('ringUtilisation', $out);
    }
}
