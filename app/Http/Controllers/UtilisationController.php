<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilisationController extends Controller
{
    public function utilisation($sbu)
    {
        $data = ApiController::listOfMaxTrafficEachSourceToDestination($sbu);
        // return $data;

        return view('utilisation', $data);
    }
}
