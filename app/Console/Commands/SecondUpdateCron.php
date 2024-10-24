<?php

namespace App\Console\Commands;

use App\Http\Controllers\RingController;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SecondUpdateCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:second-update-cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $m = (int) date('m');
        $month = RingController::convertNumToTextMonth($m);

        $date = date('Y-m-d H:i:s');
        $date = new DateTime($date);
        $weeknumber = $date->format("W");
        $year = $date->format('Y');

        // get latest weekly trend
        $query = "delete from weekly_trends wt where wt.week_number = $weeknumber";
        DB::select($query);

        // get hostlist
        $query = "
                    select 
                        h.ring, h.host_name as origin, 
                        it.interfaceid, it.interface_name as interface, 
                        it.description as terminating
                    from myapp.hosts h  
                    join myapp.interfaces it on it.hostid = h.hostid
                    where it.status = 0
                    order by ring";
        $hosts = DB::select($query);

        // long process
        foreach ($hosts as $h) {
            // get the latest weekly traffic
            $sql = "
            select 
                raw.week_number, MAX(raw.value_max) as traffic
            from (
                select 
                    to_char(to_timestamp(t.clock), 'IW') as week_number, t.value_max, t.clock 
                from hosts h 
                join (
                    select 
                        it.itemid, it.hostid, it.name
                    from 
                    items it where (it.name like '%Bits sent%' or it.name like '%Bits received%')
                ) i on h.hostid = i.hostid
                join trends_uint_$month t on i.itemid = t.itemid 
                where h.name like '%$h->origin%'
                AND i.name like '%$h->terminating%'
                and i.name like '%$h->interface%'
            ) raw where raw.week_number = '$weeknumber'
            group by raw.week_number";

            $data = DB::connection('second_db')->select($sql);

            // insert the traffic to local database
            foreach ($data as $d) {
                $sql = "insert into myapp.weekly_trends (interfaceid, year, `month`, week_number, traffic)
                    values ($h->interfaceid, '$year', '$m', $d->week_number, $d->traffic)";
                DB::select($sql);
            }
        }

        echo 'Successfully update: ' . count($hosts) . ' devices at ' . $date->format('Y-m-d H:i:s') . "\n";
    }
}
