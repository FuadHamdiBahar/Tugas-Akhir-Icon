<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\ApiModel;
use App\Models\TrendModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // $data = ApiModel::queryMaxTrafficEachSourceToDestination(
        //     'JATENG-SHELTER.GI.PURWODADI-NE8000.M14-UPE-03',
        //     'Link to JATENG-TANJUNG.JATI-NE8000.M14-UPE-02',
        //     '3',
        //     'jun'
        // );
        // return $data;
        return view('dashboard');
    }
}
