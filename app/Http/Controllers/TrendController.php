<?php

namespace App\Http\Controllers;

use App\Models\ApiModel;
use App\Models\TrendModel;
use Illuminate\Support\Facades\DB;

class TrendController extends Controller
{
    public function create($sbu)
    {

        $listMonthName = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul'];
        // $listMonthName = ['jul'];
        foreach ($listMonthName as $m) {
            $data = ApiController::sumOfMaxTrafficEachRing($sbu, $m);
            // return $data;
            foreach ($data as $d) {
                TrendModel::createTrend($sbu, $m, '2024', $d['name'], $d['data']);
            }
        }
        $out['message'] = 'Data have been created';
        return $out;
    }

    public function update($sbu)
    {
        // return $sbu;
        $m = (int) date('m');
        $m = RingController::convertNumToTextMonth($m);
        $data = ApiController::sumOfMaxTrafficEachRing($sbu, $m);

        foreach ($data as $ring) {
            TrendModel::updateTrend($sbu, $m, $ring['name'], $ring['data']);
        }
        $out['message'] = 'Data have been updated';
        return $out;
    }

    public static function createWeeklyTrend($sbu)
    {

        ini_set('max_execution_time', 600);

        // $m = (int) date('m');
        // $month = RingController::convertNumToTextMonth($m);

        // $months = [1, 2, 3, 4];
        $months = [5, 6, 7];
        foreach ($months as $month) {
            $hosts = TrendModel::getHostList($sbu);

            // return $hosts;

            $merge = array();
            foreach ($hosts as $h) {
                $data = ApiModel::queryMaxTrafficEachSourceToDestinationWeekly(
                    $h->origin,
                    $h->terminating,
                    $h->interface,
                    RingController::convertNumToTextMonth($month)
                );

                $sql = "
                select 
                    it.interfaceid
                from myapp.items i 
                join myapp.hosts h on h.hostid = i.hostid 
                join myapp.interfaces it on it.interfaceid = i.interfaceid 
                where h.host_name = '$h->origin'
                and it.description = '$h->terminating'
                and it.interface_name = '$h->interface'";

                $interfaceid = DB::connection('second_db')->select($sql)[0]->interfaceid;

                foreach ($data as $d) {
                    $sql = "insert into myapp.weekly_trends (interfaceid, `month`, week_number, traffic)
                    values ($interfaceid, '$month', $d->week_number, $d->traffic)";
                    DB::connection('second_db')->select($sql);
                }
            }
        }


        return 'BERHASIL ' . $month;
    }
}
