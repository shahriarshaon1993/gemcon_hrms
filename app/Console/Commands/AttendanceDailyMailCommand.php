<?php

namespace App\Console\Commands;

use App\Jobs\SendAttendanceMailJob;
use App\Model\Employee;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Carbon;

class AttendanceDailyMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:attendance-mail';

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
     * @return void
     * @throws BindingResolutionException
     */
    public function handle()
    {
        $fromDate = Carbon::now()->startOfMonth()->toDateString();
        $toDate = Carbon::now()->toDateString();

        $delay = 0;

        Employee::where('employee_status', 1)
            ->whereIn('employee_sbu', [1, 3, 4, 5, 6, 11, 24])
            ->where('valid', 1)
            ->where('employee_status', 1)
            ->where('deleted_at', null)
            ->where('official_email_id', '!=', null)
            ->where('employee_id_no', 194210)
            ->chunk(10, function ($employees) use ($fromDate, $toDate, &$delay) {
                foreach ($employees as $employee) {
                    SendAttendanceMailJob::dispatch($employee, $fromDate, $toDate)
                        ->onQueue('attendances')
                        ->delay(now()->addSeconds($delay));
                }

                $delay += 15;
            });
    }
}
