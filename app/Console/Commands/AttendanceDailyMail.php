<?php

namespace App\Console\Commands;

use App\Http\Controllers\hrm\AttendanceScheduleProcessController;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;

class AttendanceDailyMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Artisan command to daily attendance mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws BindingResolutionException
     */
    public function handle()
    {
        $controller = app()->make(AttendanceScheduleProcessController::class);

        return $controller->sendMail();
    }
}
