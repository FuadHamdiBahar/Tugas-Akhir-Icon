<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolygonController extends Controller
{
    public function list()
    {
        return view('polygon');
    }

    public function detail($polygonid)
    {
        return view('polygonDetail', ['polygonid' => $polygonid]);
    }
}
