<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class TrendModel
{
    public static function getNumberOfRing($sbu, $year)
    {
        $sql = "
        select 
            ring 
        from myapp.trends t 
        where sbu_name = '$sbu'
        and `year` = '$year'
        group by ring 
        ";
        return DB::connection('second_db')->select($sql);
    }

    public static function getTrendsEachSbu($sbu, $year, $ring)
    {
        $sql = "
            select 
            *
            from
            myapp.trends t 
            where sbu_name = '$sbu'
            and `year` = '$year'
            and ring = '$ring'
        ";
        return DB::connection('second_db')->select($sql);
    }

    public static function createTrend($sbu_name, $month, $year, $ring, $traffic)
    {
        $sql = "
            INSERT INTO myapp.trends (sbu_name, month, year, ring, traffic) 
            VALUES ('$sbu_name', '$month', '$year', '$ring', $traffic);
            ";
        return DB::connection('second_db')->select($sql);
    }

    public static function updateTrend($sbu_name, $month, $ring, $val)
    {
        $sql = "
        update myapp.trends set traffic = $val where sbu_name = '$sbu_name' and `month` = '$month' and ring = '$ring'
        ";
        return DB::connection('second_db')->select($sql);
    }
}
