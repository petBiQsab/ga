<?php

namespace App\Console;


use App\Console\Reporting\Exports\ExportDatasetCommand;
use App\Console\Reporting\MTL\ResetMtlCommand;
use App\Console\Reporting\Notifications\Level1NotificationMag;
use App\Console\Reporting\Notifications\Level1WeeklyReminder;
use App\Console\Reporting\Notifications\Level3NotificationMag;
use App\Console\Reporting\Notifications\RgpNotFinalizedNotification;
use App\Console\Reporting\Notifications\RgpReportMail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        Level1NotificationMag::class,
        Level1WeeklyReminder::class,
        Level3NotificationMag::class,
        ResetMtlCommand::class,
        RgpReportMail::class,
        RgpNotFinalizedNotification::class,
        \App\Console\AD_Scripts\SyncAdData::class,
        ExportDatasetCommand::class,
    ];
    protected function schedule(Schedule $schedule): void
    {
        if (env('APP_ENVIRONMENT') == 'production')
        {
            //$schedule->command('command:level1notifyMag')->weeklyOn(1, '07:00');
            //$schedule->command('command:rgp_not_finalized')->weeklyOn(1, '07:05');
            //$schedule->command('command:resetMtlCommand')->weeklyOn(3, '15:29');
            //$schedule->command('command:exportDatasetCommand')->weeklyOn(1, '07:10');

            //$schedule->command('command:level1WeeklyReminder')->weeklyOn(5, '07:00');

        }
        $schedule->command('command:sync_ad_data')->dailyAt('00:00');

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
