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


        $months = [1, 2, 3, 4, 5, 6, 7, 8];
        // $m = (int) date('m');
        $hosts = TrendModel::getHostList($sbu);
        foreach ($months as $m) {

            foreach ($hosts as $h) {
                $data = ApiModel::queryMaxTrafficEachSourceToDestinationWeekly(
                    $h->origin,
                    $h->terminating,
                    $h->interface,
                    RingController::convertNumToTextMonth($m)
                );

                $sql = "
                select 
                    it.interfaceid
                from myapp.items i 
                join myapp.hosts h on h.hostid = i.hostid 
                join myapp.interfaces it on it.interfaceid = i.interfaceid 
                where h.host_name = '$h->origin'
                and it.description = '$h->terminating'
                and it.interface_name = '$h->interface'
                and h.ring = $h->ring";

                $interfaceid = DB::connection('second_db')->select($sql)[0]->interfaceid;

                foreach ($data as $d) {
                    $sql = "insert into myapp.weekly_trends (interfaceid, year, `month`, week_number, traffic)
                    values ($interfaceid, '2024', '$m', $d->week_number, $d->traffic)";
                    DB::connection('second_db')->select($sql);
                }
            }
        }

        $url = '/ring/' . $sbu;
        return redirect($url);
    }

    public static function updateWeeklyTrend($sbu)
    {
        // gunakan week jika ada week number yang terdapat di dua bulan bersamaan
        // misalnya week 31 pada bulan juli dan agustus
        // $par = date('W');

        // gunakan month pada kondisi biasa
        $par = date('m');
        // delete aja
        TrendModel::deleteWeeklyTrend($sbu, $par);

        // buat baru dengan redirect ke createweeklytrend
        $url = '/createweeklytrend/' . $sbu;
        return redirect($url);
    }
}
