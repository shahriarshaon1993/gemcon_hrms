<?php

namespace App\Console;

use App\Console\Commands\AttendanceDailyMail;
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
//        'App\Console\Commands\twiceDaily',
//        Commands\twiceDaily::class,

        AttendanceDailyMail::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('daily:update')->everyMinute();
//        $schedule->command('dummy:update')->everyMinute()->twiceDaily(10, 13);

        $schedule->command('attendance:mail')
            ->everyMinute()
            ->appendOutputTo('storage/logs/scheduler.log');
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
