<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApiModel extends Model
{
    use HasFactory;

    public static function queryMaxTrafficEachSourceToDestination($origin, $terminating, $ring, $month)
    {
        $sql = "
                select 
                    raw.origin, '$terminating' as terminating, raw.interface, max(raw.value_max) as traffic, '$ring' as ring
                from (
                    select 
                        h.hostid, it.itemid, h.\"name\" as origin, it.interface, it.terminating, to_timestamp(t.clock) as waktu, t.value_max   
                    from hosts h 
                    join (
                        select sp.itemid, sp.hostid, sp.\"name\", split_part(sp.regexp_replace, '(', 1) as interface, split_part(sp.regexp_replace, '(', 2) as terminating  from (
                            select
                                i.itemid, i.hostid, i.\"name\", regexp_replace(i.\"name\", '\):.*', ' ')
                            from items i 
                            where (i.\"name\" like '%Bits sent%' or i.\"name\" like '%Bits received%')
                        ) sp
                    ) it on h.hostid = it.hostid
                    join trends_uint_$month t on it.itemid = t.itemid 
                    where h.\"name\" like '%$origin%'
                    and it.\"name\" like '%$terminating%'
                ) raw
                group by raw.origin, raw.terminating, raw.interface";

        $data = DB::select($sql);
        foreach ($data as $d) {
            if (str_contains($d->interface, 'Interface 100GE')) {
                $d->capacity =  100000000000;
            } elseif (str_contains($d->interface, 'Interface 50|100GE0')) {
                $d->capacity =  100000000000;
            } elseif (str_contains($d->interface, 'Interface HundredGigE')) {
                $d->capacity =  100000000000;
            } elseif (str_contains($d->interface, 'Interface et')) {
                $d->capacity =  100000000000;
            } elseif (str_contains($d->interface, 'Interface GigabitEthernet')) {
                $d->capacity =  10000000000;
            } elseif (str_contains($d->interface, 'Interface Te')) {
                $d->capacity =  10000000000;
            } elseif (str_contains($d->interface, 'Interface TenGig')) {
                $d->capacity =  10000000000;
            } elseif (str_contains($d->interface, 'Interface xe')) {
                $d->capacity =  10000000000;
            } elseif (str_contains($d->interface, 'Interface Gi')) {
                $d->capacity =  1000000000;
            }
        }
        return $data;
    }

    public static function queryTrafficMonth($origin, $terminating, $type, $month)
    {
        $sql = "
        select 
            round(rekap.value_max / 1000000000, 1) as traffic, to_char(rekap.waktu, 'DD-MM-YYYY') as date, to_char(rekap.waktu, 'HH24:MI') as time
        from (
            SELECT 
                to_timestamp(tuj.clock) as waktu, 
                tuj.value_max
            FROM 
                hosts h 
            JOIN 
                items i ON i.hostid = h.hostid 
            JOIN 
                trends_uint_$month tuj ON tuj.itemid = i.itemid 
            WHERE 
                h.\"name\" LIKE '%$origin%'
                AND i.\"name\" LIKE '%$terminating%'
                AND i.\"name\" LIKE '%$type%'
            ORDER BY 
                tuj.clock ASC
        ) rekap";

        return DB::select($sql);
    }

    public static function queryTrafficWeek($origin, $terminating, $type, $month)
    {
        $sql = "
       select 
            round(rekap.value_max / 1000000000, 1) as traffic, to_char(rekap.waktu, 'DD-MM-YYYY') as date, to_char(rekap.waktu, 'HH24:MI') as time
        from (
            SELECT 
                to_timestamp(tuj.clock) as waktu, 
                tuj.value_max
            FROM 
                hosts h 
            JOIN 
                items i ON i.hostid = h.hostid 
            JOIN 
                trends_uint_$month tuj ON tuj.itemid = i.itemid 
            WHERE 
                h.\"name\" LIKE '%$origin%'
                AND i.\"name\" LIKE '%$terminating%'
                AND i.\"name\" LIKE '%$type%'
            ORDER BY 
                tuj.clock ASC
        ) rekap
        where rekap.waktu > current_date - interval '7 days'";

        return DB::select($sql);
    }

    public static function queryMaxTrafficEachSourceToDestinationWeekly($origin, $terminating, $ring, $month)
    {
        $sql = "
            select 
                * 
            from (
                select 
                    raw.origin, raw.terminating, '$ring' as ring, cast(raw.week_number as integer), MAX(raw.value_max) as traffic
                from (
                    select 
                        to_timestamp(t.clock), to_char(to_timestamp(t.clock), 'IW') as week_number, 
                        h.\"name\" as origin, '$terminating' as terminating,
                        t.value_max  
                    from hosts h 
                    join (
                        select 
                            it.itemid, it.hostid, it.\"name\"
                        from items it where it.\"name\" LIKE '%Bits sent%' OR it.name LIKE '%Bits received%'
                    ) i on h.hostid = i.hostid
                    join trends_uint_$month t on i.itemid = t.itemid  
                    where h.name LIKE '%$origin%'
                    AND i.name LIKE '%$terminating%'
                ) raw
                group by raw.week_number, raw.origin, raw.terminating
            ) res 
            where res.week_number < date_part('week', current_date)
        ";

        return DB::select($sql);
    }
}
