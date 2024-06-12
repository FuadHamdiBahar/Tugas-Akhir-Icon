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
                    raw.origin, raw.terminating, raw.interface, max(raw.value_max), '$ring' as ring
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
                $d->utilisation = $d->max / 1000000000;
                $d->capacity =  100;
            } elseif (str_contains($d->interface, 'Interface 50|100GE0')) {
                $d->utilisation = $d->max / 1000000000;
                $d->capacity =  100;
            } elseif (str_contains($d->interface, 'Interface HundredGigE')) {
                $d->utilisation = $d->max / 1000000000;
                $d->capacity =  100;
            } elseif (str_contains($d->interface, 'Interface et')) {
                $d->utilisation = $d->max / 1000000000;
                $d->capacity =  100;
            } elseif (str_contains($d->interface, 'Interface GigabitEthernet')) {
                $d->utilisation = $d->max / 100000000;
                $d->capacity =  10;
            } elseif (str_contains($d->interface, 'Interface Te')) {
                $d->utilisation = $d->max / 100000000;
                $d->capacity =  10;
            } elseif (str_contains($d->interface, 'Interface TenGig')) {
                $d->utilisation = $d->max / 100000000;
                $d->capacity =  10;
            } elseif (str_contains($d->interface, 'Interface xe')) {
                $d->utilisation = $d->max / 100000000;
                $d->capacity =  10;
            } elseif (str_contains($d->interface, 'Interface Gi')) {
                $d->utilisation = $d->max / 10000000;
                $d->capacity =  1;
            }
        }
        return $data;
    }

    public static function queryTraffic($origin, $terminating, $start, $end, $type)
    {
        $sql = "
        select 
            round(rekap.value_max / 1000000000, 1) as value_max
        from (
            SELECT 
                to_timestamp(tuj.clock) as waktu, 
                tuj.value_max
            FROM 
                hosts h 
            JOIN 
                items i ON i.hostid = h.hostid 
            JOIN 
                interface itf ON itf.interfaceid = i.interfaceid 
            JOIN 
                trends_uint tuj ON tuj.itemid = i.itemid 
            WHERE 
                h.description LIKE '%$origin%'
                AND i.\"name\" LIKE '%$terminating%'
                AND i.\"name\" LIKE '%$type%'
            ORDER BY 
                tuj.clock DESC
        ) rekap
        where rekap.waktu between '$start' and '$end'";

        return DB::select($sql);
    }
}
