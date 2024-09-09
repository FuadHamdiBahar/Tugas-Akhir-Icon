<?php

namespace App\Console\Commands;

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
        $query = "
        select 
            h.ring, h.host_name as origin, 
            it.interfaceid, it.interface_name as interface, 
            it.description as terminating
        from myapp.items i 
        join myapp.hosts h on h.hostid = i.hostid 
        join myapp.interfaces it on it.interfaceid = i.interfaceid 
        and it.interface_name != 'TIDAK ADA'
        and it.status = 1
        order by ring";
        // echo DB::select($query);

        echo 'Selamat Siang Fuad Hamdi Bahar';
    }
}
