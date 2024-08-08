<?php

namespace App\Http\Controllers;

use App\Models\TrendModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterController extends Controller
{
    public function master()
    {
        // $query = TrendModel::getMaster();
        // $data = array(
        //     'data' => $query,
        // );
        return view('master');
    }

    public function interface($hostid)
    {

        $data = array(
            'hostid' => $hostid,
        );
        return view('interface', $data);
    }
}
