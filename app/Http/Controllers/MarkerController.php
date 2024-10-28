<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use Illuminate\Http\Request;

class MarkerController extends Controller
{
    public function list()
    {
        $query = Marker::all();

        return view('listMarker', ['data' => $query]);
    }

    public function detail($markerid)
    {
        return view('markerDetail', ['markerid' => $markerid]);
    }
}
