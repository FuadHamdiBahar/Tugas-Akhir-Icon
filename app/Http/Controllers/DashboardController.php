<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\TrendModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class DashboardController extends Controller
{
    public function dashboard()
    {


        return view('dashboard');
    }
}
