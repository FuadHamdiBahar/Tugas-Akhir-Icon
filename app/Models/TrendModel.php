<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class TrendModel
{
    public static function getTopFive()
    {
        $sql = "
        select 
            lower(concat(t.sbu_name, ' ', t.ring)) as name, format(t.traffic / 1000000000, 1) as traffic  
        from myapp.trends t 
        where t.`month` = 'jul'
        order by t.traffic desc
        limit 5
        ";
        return DB::connection('second_db')->select($sql);
    }

    public static function topEachSBU()
    {
        $sql = "
            select 
                lower(concat(t.sbu_name, ' ', t.ring)) as name, format(t.traffic / 1000000000, 1) as traffic  
            from (
                select 
                    sbu_name, max(t.traffic) as traffic  
                from myapp.trends t 
                where t.`month` = 'jul'
                group by sbu_name
            ) raw 
            join myapp.trends t on t.traffic = raw.traffic
        ";

        return DB::connection('second_db')->select($sql);
    }

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
