<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilisationController extends Controller
{
    public function utilisation($sbu)
    {
        $month = RingController::convertNumToTextMonth();
        $data = ApiController::listOfMaxTrafficEachSourceToDestination($sbu, $month);
        return view('utilisation', $data);
    }
}
