<?php

namespace App\Console\Commands;

use App\Http\Controllers\RingController;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update weekly trends database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $m = (int) date('m');
        // $m = 6;
        $month = RingController::convertNumToTextMonth($m);

        $date = date('Y-m-d H:i:s');
        $date = new DateTime($date);
        $weeknumber = $date->format("W");
        // $weeknumber = 23;
        $year = $date->format('Y');

        // get latest weekly trend
        $query = "delete from weekly_trends wt where wt.week_number = $weeknumber and wt.year = $year";
        DB::select($query);

        // get hostlist
        $query = "
                select 
                    it.ring, h.host_name as origin, 
                    it.interfaceid, it.interface_name as interface, 
                    it.description as terminating
                from myapp.hosts h  
                join myapp.interfaces it on it.hostid = h.hostid
                order by ring";
        $hosts = DB::select($query);

        $dataUpdated = 0;
        // long process to submit
        foreach ($hosts as $h) {
            $sql = "
            select 
                raw.week_number, MAX(raw.value_max) as traffic, raw.year
            from (
                select 
                    to_char(to_timestamp(t.clock), 'IW') as week_number, t.value_max, to_char(to_timestamp(t.clock), 'YYYY') as year
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
            ) raw where raw.week_number = '$weeknumber' and raw.year = '$year'
            group by raw.week_number, raw.year";

            $data = DB::connection('second_db')->select($sql);

            if (count($data) > 0) {
                $dataUpdated += 1;
            } else {
                echo 'Do not find the pair of Originating Terminating of ' . $h->origin . " " . $h->terminating . " " . $h->interface;
            }

            // insert the traffic to local database
            foreach ($data as $d) {
                $sql = "insert into myapp.weekly_trends (interfaceid, year, `month`, week_number, traffic)
                    values ($h->interfaceid, '$year', '$m', $d->week_number, $d->traffic)";
                DB::select($sql);
            }
        }

        echo 'Successfully update: ' . $dataUpdated . ' pair of Originating Terminating at ' . $date->format('Y-m-d H:i:s') . "\n";
    }
}
