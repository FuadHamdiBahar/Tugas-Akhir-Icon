<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PsSarpenController extends Controller
{
    public function index()
    {
        $data['date'] = date('F', strtotime(date('d-m-Y')));

        return view('pssarpen', $data);
    }
}
