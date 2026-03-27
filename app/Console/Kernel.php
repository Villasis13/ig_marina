<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
//        $schedule->command('backup:database')->dailyAt('8:30');
        $schedule->command('log:database')->dailyAt('13:28');
//        $schedule->command('sunat:enviar-comprobantes')->dailyAt('8:30');
        //$schedule->command('sunatFac:enviar-comprobantes')->dailyAt('22:46');
    }

    /**
     * Register the commands for the application.
     *
     *
     *
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
