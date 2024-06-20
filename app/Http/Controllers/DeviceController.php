<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index($origin, $terminating)
    {
        $data = array(
            'origin' => $origin,
            'terminating' => $terminating,
            'month' => date('F', strtotime(date('d-m-Y')))
        );
        return view('device', $data);
    }
}
