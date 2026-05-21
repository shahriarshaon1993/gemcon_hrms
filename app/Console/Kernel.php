<?php

namespace App\Console;

use App\Console\Commands\AttendanceDailyMailCommand;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AttendanceDailyMailCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:attendance-mail')
            ->dailyAt('18:00')
            ->when(function () {
                return Carbon::now()->isLastOfMonth();
            });

        $schedule->command('send:birthday-mail')->dailyAt('14:35');
    }

    /**
     * Set local Timezone
     *
     * @return string
     */
    public function scheduleTimezone()
    {
        return 'Asia/Dhaka';
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
