<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        echo 'Selamat Siang Fuad Hamdi Bahar';
    }
}
