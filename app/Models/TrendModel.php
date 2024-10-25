<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use OutOfBoundsException;

class TrendModel
{
    public static function deleteInterface($interfaceid)
    {
        $sql = "delete from interfaces
                where interfaceid = $interfaceid";
        return DB::select($sql);
    }
    public static function updateInterface(Request $request)
    {
        $interface_name = $request->input('interface_name');
        $description = $request->input('description');
        $capacity = $request->input('capacity');
        $interfaceid = $request->input('interfaceid');
        $email = session('email');

        $sql = "update interfaces
                set interface_name = '$interface_name',
                    description = '$description',
                    capacity = '$capacity',
                    updated_by = '$email'
                where interfaceid = $interfaceid";
        return DB::select($sql);
    }

    public static function createInterface(Request $request)
    {
        $hostid = $request->input('hostid');
        $interface_name = $request->input('interface_name');
        $description = $request->input('description');
        $capacity = $request->input('capacity');
        $email = session('email');

        $sql = "insert into
                interfaces (hostid, interface_name, description, capacity, status, created_by, updated_by)
                values ($hostid, '$interface_name', '$description', $capacity, 1, '$email', '$email')";
        return DB::select($sql);
    }

    public static function retrieveSingleInterface($interfaceid)
    {
        $sql = "select
                *
                from interfaces i
                where i.interfaceid = $interfaceid";

        return DB::select($sql)[0];
    }
    public static function retrieveInterface($hostid)
    {
        $data = DB::select("select * from interfaces i where i.hostid = $hostid");
        return $data;
    }

    public static function deleteHost($hostid)
    {
        $sql = "select * from interfaces i where i.hostid = $hostid";
        $query = DB::select($sql);
        foreach ($query as $q) {
            self::deleteInterface($q->interfaceid);
        }

        $sql = "delete 
                from hosts 
                where hostid = $hostid";
        return DB::select($sql);
    }

    public static function createHost(Request $request)
    {
        $sbu_name = $request->input('sbuname');
        $ring = $request->input('idring');
        $hostname = $request->input('hostname');
        $email = session('email');
        $sql = "insert 
                into hosts (sbu_name, ring, host_name, created_by, updated_by)
                values ('$sbu_name', $ring, '$hostname', '$email', '$email')";
        return DB::select($sql);
    }

    public static function updateHost(Request $request)
    {
        // id
        $hid = $request->input('hid');

        // data
        $sbu_name = $request->input('sbuname');
        $ring = $request->input('idring');
        $hostname = $request->input('hostname');
        $email = session('email');

        $sql = "update 
                     hosts 
                 set 
                     sbu_name = '$sbu_name',
                     ring = $ring,
                     host_name = '$hostname',
                     updated_by = '$email'
                 where hostid = $hid";
        return DB::select($sql);
    }

    public static function retrieveSingleHost($hostid)
    {
        $sql = "select
                *
                from hosts h where h.hostid = $hostid";

        return DB::select($sql)[0];
    }

    public static function retrieveHost()
    {
        $sql = "select 
                h.*, count(*) as jumlah
                from hosts h 
                left join interfaces i on h.hostid = i.hostid 
                group by h.hostid
                order by h.updated_at desc";
        return DB::select($sql);
    }

    public static function updateMaster(Request $request)
    {
        // id
        $hid = $request->input('hid');
        $iid = $request->input('iid');

        // data
        $sbu_name = $request->input('sbuname');
        $ring = $request->input('idring');
        $hostname = $request->input('hostname');

        $sql = "update 
                    hosts 
                set 
                    sbu_name = '$sbu_name',
                    ring = $ring,
                    host_name = '$hostname'
                where hostid = $hid";
        DB::select($sql);


        $interfacename = $request->input('interfacename');
        $description = $request->input('description');
        $capacity = $request->input('capacity');

        $sql = "update 
        interfaces 
        set
            interface_name = '$interfacename',
            description = '$description',
            capacity = $capacity
        where interfaceid = $iid";
        DB::select($sql);


        return response(json_encode(['message' => 'Berhasil']));
    }

    public static function getSingleMaster($hid, $iid)
    {
        $sql = "select 
                *
                from hosts h 
                join interfaces i on h.hostid = i.hostid 
                where h.hostid = $hid
                and i.interfaceid = $iid";

        try {
            return DB::select($sql)[0];
        } catch (\Throwable $th) {
            return 'OutOfBoundsException';
        }
    }

    public static function getMaster()
    {
        $sql = "select 
                *
                from hosts h 
                join interfaces i on h.hostid = i.hostid
                order by sbu_name, ring";
        return DB::select($sql);
    }

    public static function deleteWeeklyTrend($sbu, $par)
    {
        $sql = "
        delete wt
        from weekly_trends wt
        join myapp.interfaces i on wt.interfaceid = i.interfaceid 
        join myapp.items it on it.interfaceid = i.interfaceid 
        join myapp.hosts h on h.hostid = it.hostid 
        where h.sbu_name = '$sbu'
        and wt.`month` = $par
        and i.interface_name != 'TIDAK ADA'
        ";
        return DB::select($sql);
    }

    public static function getRingTrendMonth($sbu, $month)
    {
        $sql = "
        select 
            raw.ring as name, round(sum(raw.traffic) / 1000000000, 1) as data
        from(
            select 
                h.ring, it.interface_name, max(wt.traffic) as traffic
            from myapp.hosts h  
            join myapp.interfaces it on it.hostid = h.hostid 
            join myapp.weekly_trends wt on it.interfaceid = wt.interfaceid 
            where h.sbu_name = '$sbu'
            and it.status = 1
            and wt.month = '$month'
            group by h.ring, it.interface_name 
        ) raw group by raw.ring
        order by name";
        return DB::select($sql);
    }

    public static function getHostList($sbu)
    {
        $sql = "
        select 
            h.ring, h.host_name as origin, 
            it.interfaceid, it.interface_name as interface, 
            it.description as terminating
        from myapp.items i 
        join myapp.hosts h on h.hostid = i.hostid 
        join myapp.interfaces it on it.interfaceid = i.interfaceid 
        where h.sbu_name = '$sbu'
        and it.interface_name != 'TIDAK ADA
        and it.status = 1
        order by ring'
        ";
        return DB::select($sql);
    }

    public static function getRingTrend($sbu)
    {
        $sql = "
        select 
            res.ring as name, group_concat(res.traffic order by res.month asc) as data
        from (
            select 
                raw.ring, raw.month, round(sum(raw.traffic) / 1000000000, 1) as traffic
            from(
                select 
                    h.ring, it.interface_name, wt.month, max(wt.traffic) as traffic
                from myapp.hosts h 
                join myapp.interfaces it on it.hostid = h.hostid 
                join (select * from myapp.weekly_trends wt order by wt.month, wt.week_number) wt on it.interfaceid = wt.interfaceid 
                where h.sbu_name = '$sbu'
                and it.status = 1
                group by h.ring, it.interface_name, wt.month 
            ) raw group by raw.ring, raw.month
            order by raw.ring, raw.month
        ) res group by res.ring";

        return DB::select($sql);
    }

    public static function getTotalUtilizationEachMonth($year)
    {
        $sql = "
        select 
            res.month, sum(res.traffic) as utilized,
            sum(res.capacity) - sum(res.traffic) as idle,
            sum(res.capacity) as capacity
        from (
            select 
                h.ring, h.host_name, it.interface_name, wt.month,
                round(it.capacity / 1000000000, 1) as capacity, 
                round(max(wt.traffic) / 1000000000, 1) as traffic
            from myapp.hosts h  
            join myapp.interfaces it on it.hostid = h.hostid 
            join myapp.weekly_trends wt on it.interfaceid = wt.interfaceid 
            where it.interface_name != 'TIDAK ADA'
            and wt.year = '2024'
            group by h.host_name, it.interface_name, h.ring, it.capacity, wt.`month`  
            order by h.host_name, wt.month
        ) res group by res.month order by res.month";
        return DB::select($sql);
    }

    public static function  getTotalUtilization($year, $month)
    {
        $sql = "
        select 
            sum(raw.traffic) as utilized, sum(raw.capacity) - sum(raw.traffic) as idle, sum(raw.capacity) as capacity 
        from (
            select 
                h.ring, h.host_name, it.interface_name, 
                round(it.capacity / 1000000000, 1) as capacity, 
                round(max(wt.traffic) / 1000000000, 1) as traffic
            from myapp.hosts h 
            join myapp.interfaces it on it.hostid = h.hostid
            join myapp.weekly_trends wt on it.interfaceid = wt.interfaceid 
            where it.interface_name != 'TIDAK ADA'
            and it.status = 1
            and wt.month = $month
            and wt.year = '$year'
            group by h.host_name, it.interface_name, h.ring, it.capacity 
        ) raw
        ";

        return DB::select($sql);
    }

    public static function getLocalUtilization($sbu_name, $year, $month)
    {
        $sql = "select 
                    sum(raw.traffic) as utilized, sum(raw.capacity) - sum(raw.traffic) as idle, sum(raw.capacity) as capacity 
                from (
                    select 
                        h.ring, h.host_name, it.interface_name, 
                        round(it.capacity / 1000000000, 1) as capacity, 
                        round(max(wt.traffic) / 1000000000, 1) as traffic
                    from myapp.hosts h
                    join myapp.interfaces it on it.hostid = h.hostid 
                    join myapp.weekly_trends wt on it.interfaceid = wt.interfaceid 
                    where h.sbu_name = '$sbu_name'
                    and it.interface_name != 'TIDAK ADA'
                    and it.status = 1
                    and wt.month = $month
                    and wt.year = '$year'
                    group by h.host_name, it.interface_name, h.ring, it.capacity 
                ) raw";
        return DB::select($sql);
    }

    public static function getUtilizationList($sbu, $month)
    {
        $sql = "
        select 
            h.ring, h.host_name, it.interface_name,
            round(it.capacity / 1000000000, 1) as capacity, 
            round(max(wt.traffic) / 1000000000, 1) as traffic
        from myapp.hosts h 
        join myapp.interfaces it on it.hostid = h.hostid 
        join myapp.weekly_trends wt on it.interfaceid = wt.interfaceid 
        where h.sbu_name = '$sbu'
        and wt.`month` = MONTH(CURRENT_DATE()) and it.status = 1
        group by h.host_name, it.interface_name, h.ring, it.capacity
        order by ring";

        return DB::select($sql);
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

        return DB::select($sql);
    }

    public static function getWeeklyTrend($sbu, $fw, $cw)
    {
        $sql = "select 
                    res.ring as name, group_concat(res.traffic order by res.week_number asc) as data
                from (
                    select 
                        raw.ring, wt.week_number, round(sum(wt.traffic) / 1000000000, 1) as traffic
                    from (
                        select 
                            h.sbu_name, h.ring, h.host_name, i2.interface_name, i2.description, wt.week_number, count(*) as jumlah, max(wt.id) as wtid
                        from myapp.hosts h 
                        join myapp.interfaces i2 on i2.hostid = h.hostid
                        join myapp.weekly_trends wt on wt.interfaceid = i2.interfaceid
                        where h.sbu_name = '$sbu'
                        and i2.status = 1
                        and wt.week_number >= $fw
                        and wt.week_number <= $cw
                        group by h.sbu_name, h.ring, h.host_name, i2.interface_name, i2.description, wt.week_number
                    ) raw join myapp.weekly_trends wt on raw.wtid = wt.id 
                    group by raw.ring, wt.week_number
                ) res group by res.ring";

        return DB::select($sql);
    }

    public static function getPrevious($before, $sbu_name, $ring)
    {
        $sql = "
        select 
            lower(concat(res.sbu_name, ' ', res.ring)) as name, round(sum(res.traffic) / 1000000000, 1) as traffic
        from (
            select 
                h.sbu_name, h.ring, h.host_name, it.interface_name, wt.`month`, max(wt.traffic) as traffic
            FROM myapp.hosts h 
            JOIN myapp.interfaces it ON it.hostid = h.hostid 
            JOIN myapp.weekly_trends wt ON it.interfaceid = wt.interfaceid
            where h.sbu_name = '$sbu_name'
            and h.ring = '$ring'
            and wt.`month` = $before
            group by h.sbu_name, h.ring, h.host_name, it.interface_name, wt.`month`
        ) res group by res.sbu_name, res.ring
        ";
        return DB::select($sql);
    }

    public static function getTopFive($month)
    {
        $sql = "
        WITH ranked_traffic AS (
            SELECT 
                raw.sbu_name, 
                raw.ring, 
                raw.month, 
                ROUND(SUM(raw.traffic) / 1000000000, 1) AS traffic,
                ROW_NUMBER() OVER (PARTITION BY raw.sbu_name ORDER BY SUM(raw.traffic) DESC) AS rn
            FROM (
                SELECT 
                    h.sbu_name, 
                    h.ring, 
                    it.interface_name, 
                    wt.month, 
                    MAX(wt.traffic) AS traffic
                FROM myapp.hosts h 
                JOIN myapp.interfaces it ON h.hostid = it.hostid 
                JOIN myapp.weekly_trends wt ON it.interfaceid = wt.interfaceid 
                WHERE it.interface_name != 'TIDAK ADA'
                AND wt.`month` = $month
                GROUP BY h.ring, it.interface_name, wt.month, h.sbu_name 
            ) raw 
            GROUP BY raw.ring, raw.month, raw.sbu_name
        )
        SELECT 
            lower(concat(sbu_name, ' ', ring)) as name,
            traffic
        FROM ranked_traffic
        WHERE rn = 1
        ORDER BY traffic desc
        LIMIT 5;
        ";
        return DB::select($sql);
    }

    public static function topEachSBU($month)
    {
        $sql = "
            WITH ranked_traffic AS (
            SELECT 
                raw.sbu_name, 
                raw.ring, 
                raw.month, 
                ROUND(SUM(raw.traffic) / 1000000000, 1) AS traffic,
                ROW_NUMBER() OVER (PARTITION BY raw.sbu_name ORDER BY SUM(raw.traffic) DESC) AS rn
            FROM (
                SELECT 
                    h.sbu_name, 
                    h.ring, 
                    it.interface_name, 
                    wt.month, 
                    MAX(wt.traffic) AS traffic
                FROM myapp.hosts h 
                JOIN myapp.interfaces it ON it.hostid = h.hostid 
                JOIN myapp.weekly_trends wt ON it.interfaceid = wt.interfaceid 
                WHERE it.interface_name != 'TIDAK ADA'
                AND wt.`month` = $month
                GROUP BY h.ring, it.interface_name, wt.month, h.sbu_name 
            ) raw 
            GROUP BY raw.ring, raw.month, raw.sbu_name
        )
        SELECT 
            lower(concat(sbu_name, ' ', ring)) as name,
            traffic
        FROM ranked_traffic
        WHERE rn = 1
        ";

        return DB::select($sql);
    }

    public static function topEachMonth()
    {
        $sql = "
        WITH ranked_traffic AS (
            select 
                *,	row_number() over(partition by las.month order by las.traffic desc) as rn
            from (
                select 
                    res.sbu_name, res.ring, res.month, round(sum(res.traffic) / 1000000000, 1) as traffic
                from (
                    select raw.sbu_name, raw.ring, raw.host_name, raw.interface_name, raw.month,max(raw.traffic) as traffic from(
                        select 
                            h.sbu_name,  h.host_name, it.interface_name, h.ring, wt.month, wt.week_number, wt.traffic 
                        from myapp.hosts h 
                        join myapp.interfaces it on it.hostid = h.hostid 
                        join myapp.weekly_trends wt on it.interfaceid = wt.interfaceid 
                    ) raw group by raw.month, raw.interface_name, raw.host_name, raw.ring, raw.sbu_name
                ) res group by res.sbu_name, res.ring, res.month
                order by res.month
            ) las
        )
        SELECT 
            lower(concat(sbu_name, ' ', ring)) as name,
            month,
            traffic
        FROM ranked_traffic
        WHERE rn = 1
        order by month
        ";
        return DB::select($sql);
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
        return DB::select($sql);
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
        return DB::select($sql);
    }

    public static function createTrend($sbu_name, $month, $year, $ring, $traffic)
    {
        $sql = "
            INSERT INTO myapp.trends (sbu_name, month, year, ring, traffic) 
            VALUES ('$sbu_name', '$month', '$year', '$ring', $traffic);
            ";
        return DB::select($sql);
    }

    public static function updateTrend($sbu_name, $month, $ring, $val)
    {
        $sql = "
        update myapp.trends set traffic = $val where sbu_name = '$sbu_name' and `month` = '$month' and ring = '$ring'
        ";
        return DB::select($sql);
    }

    public static function createWeeklyTrend($sbu_name, $ring, $month, $week_number, $traffic)
    {
        $sql = "
            insert into myapp.weekly_trends (sbu_name, ring, month, week_number, traffic)
            values ('$sbu_name', '$ring', '$month', $week_number, $traffic)
        ";

        return DB::select($sql);
    }
}
