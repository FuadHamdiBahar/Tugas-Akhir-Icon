<?php

namespace App\Console;

use App\Console\Commands\UpdateCron;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        UpdateCron::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('update:cron')
            ->everyFiveSeconds();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
