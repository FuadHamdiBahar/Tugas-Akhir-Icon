<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApiModel extends Model
{
    use HasFactory;

    public static function queryMaxTrafficEachSourceToDestination($start, $end, $source, $destination, $ring, $type)
    {
        // $sql = "

        // ";
        $sql = "
                select 
                    raw.origin, raw.terminating, max(raw.value_max), $ring as ring
                from (
                    select 
                        mh.host, 
                        mh.name as origin, 
                        it.\"name\" as terminating,
                        mt.waktu,
                        mt.value_max
                    from (
                        select * from hosts h where h.\"name\" like 'SB%'
                    ) mh
                    join (
                        select * from items i where i.name like '%$type%'
                        ) it on it.hostid = mh.hostid
                    join (
                        select * from (
                            select tu.itemid, to_timestamp(tu.clock) as waktu, tu.value_max from trends_uint_may tu 
                        ) trend where trend.waktu between '$start' and '$end'
                    ) mt on it.itemid = mt.itemid
                ) raw
                where raw.origin like '%$source%'
                and raw.terminating like '%$destination%'
                group by raw.origin, raw.terminating";

        return DB::select($sql);
    }

    public static function queryTraffic($start, $end, $source, $destination, $type)
    {
        $sql = "
        select 
        * 
        from (
            SELECT 
                h.hostid, 
                h.host, 
                h.description, 
                i.\"name\", 
                itf.ip, 
                itf.port, 
                to_timestamp(tuj.clock) as waktu, 
                tuj.value_min, 
                tuj.value_max, 
                tuj.value_avg 
            FROM 
                hosts h 
            JOIN 
                items i ON i.hostid = h.hostid 
            JOIN 
                interface itf ON itf.interfaceid = i.interfaceid 
            JOIN 
                trends_uint tuj ON tuj.itemid = i.itemid 
            WHERE 
                h.host = '$source'
                AND i.\"name\" LIKE '%$destination%'
                AND i.\"name\" LIKE '%$type%'
            ORDER BY 
                tuj.clock DESC
        ) rekap
        where rekap.waktu between '$start' and '$end'";

        return DB::select($sql);
    }
}
