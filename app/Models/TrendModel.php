<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class TrendModel
{
    public static function getTotalUtilizationEachMonth($year)
    {
        $sql = "
        select 
            u.year, 
            u.`month`, 
            round((sum(u.value) / sum(i.capacity)) * 100, 1) as utilized, 
            100 - round((sum(u.value) / sum(i.capacity)) * 100, 1) as idle 
        from myapp.hosts h 
        join myapp.interfaces i on i.hostid = h.hostid 
        join myapp.utilization u on u.interfaceid = i.interfaceid
        where h.status = 1
        and u.`year` = $year
        and i.capacity >= 100000000000
        and u.value != 0
        group by u.year, u.`month`";
        return DB::connection('second_db')->select($sql);
    }
    public static function getTotalUtilization($year, $month)
    {
        $sql = "
        select 
            sum(u.value) / sum(i.capacity) as utilized, (sum(i.capacity) - sum(u.value)) / sum(i.capacity) as idle 
        from myapp.hosts h 
        join myapp.interfaces i on i.hostid = h.hostid  
        join myapp.utilization u on u.interfaceid = i.interfaceid 
        where i.capacity >= 100000000000
        and h.status = 1
        and u.`year` = $year
        and u.`month` = '$month'
        and u.value != 0
        ";

        return DB::connection('second_db')->select($sql);
    }

    public static function getUtilizationList($sbu, $month)
    {
        $sql = "
        select 
            h.ring, h.origin, h.terminating, i.interface_name, i.capacity, u.value  
        from myapp.hosts h 
        join myapp.interfaces i on i.hostid = h.hostid 
        join myapp.utilization u on u.interfaceid = i.interfaceid 
        where h.sbu_name = '$sbu'
        and u.`month` = '$month'";

        return DB::connection('second_db')->select($sql);
    }

    public static function getWeeklyNumberOfRing($sbu)
    {
        $sql = "
        select 
            wt.ring 
        from myapp.weekly_trends wt 
        WHERE wt.week_number  >= 25
        AND wt.week_number  <= 28
        and wt.sbu_name = '$sbu'
        group by wt.ring 
        order by wt.ring
        ";

        return DB::connection('second_db')->select($sql);
    }

    public static function getWeeklyTrend($sbu, $ring, $fw, $cw)
    {
        $sql = "
        SELECT 
            *
        FROM myapp.weekly_trends wt 
        WHERE wt.week_number >= $fw
        AND wt.week_number <= $cw
        and wt.sbu_name = '$sbu'
        and wt.ring = '$ring'
        order by wt.sbu_name, wt.ring, wt.week_number 
        ";

        return DB::connection('second_db')->select($sql);
    }

    public static function monthDifference($before, $current)
    {
        $sql = "
        select
            lower(concat(cur.sbu_name, ' ', cur.ring)) as name,
            format(cur.traffic / 1000000000, 1) as cur_traffic,
            format(bef.traffic / 1000000000, 1) AS bef_traffic
        FROM (
            SELECT 
                t.sbu_name, 
                t.ring, 
                t.traffic 
            FROM (
                SELECT 
                    sbu_name, 
                    MAX(traffic) AS traffic
                FROM myapp.trends 
                WHERE `month` = '$current'
                GROUP BY sbu_name 
            ) raw 
            JOIN myapp.trends t ON t.sbu_name = raw.sbu_name AND t.traffic = raw.traffic
        ) cur 
        JOIN myapp.trends bef 
        ON cur.sbu_name = bef.sbu_name 
        AND bef.`month` = '$before' 
        AND bef.ring = cur.ring
        ";
        return DB::connection('second_db')->select($sql);
    }

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

    public static function topEachMonth()
    {
        $sql = "
       select 
            lower(concat(t.sbu_name, ' ', t.ring)) as name, t.month, format(t.traffic / 1000000000, 1) as traffic
        from (
            select 
                t.`month`, max(t.traffic) as traffic
            from
                myapp.trends t 
            where t.year = 2024
            group by t.`month`  
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
        order by ring
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

    public static function createWeeklyTrend($sbu_name, $ring, $month, $week_number, $traffic)
    {
        $sql = "
            insert into myapp.weekly_trends (sbu_name, ring, month, week_number, traffic)
            values ('$sbu_name', '$ring', '$month', $week_number, $traffic)
        ";

        return DB::connection('second_db')->select($sql);
    }
}
