<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RingController extends Controller
{
    public function ring($sbu)
    {
        $data = ApiController::listOfMaxTrafficEachRing($sbu);
        return view('ring', $data);
    }
}
