<?php

namespace App\Console\Commands;

use App\Jobs\SendBirthdayMailJob;
use App\Model\Employee;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BirthDayMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:birthday-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Artisan command to daily birthday mail';

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
     */
    public function handle()
    {
        $todayMonth = Carbon::today()->month;
        $todayDay = Carbon::today()->day;

        $employees = Employee::query()
            ->where('employees.valid', 1)
            ->where('employees.employee_status', 1)
            ->whereNull('employees.deleted_at')
            ->join('employee_personal_infos as epi', 'employees.id', '=', 'epi.employee_id')
            ->where(function ($query) use ($todayMonth, $todayDay) {

                $query->where(function ($q) use ($todayMonth, $todayDay) {
                    $q->whereNotNull('epi.employee_dob_actual')
                        ->whereMonth('epi.employee_dob_actual', $todayMonth)
                        ->whereDay('epi.employee_dob_actual', $todayDay);
                })
                    ->orWhere(function ($q) use ($todayMonth, $todayDay) {
                        $q->whereNull('epi.employee_dob_actual')
                            ->whereNotNull('epi.employee_dob_certificate')
                            ->whereMonth('epi.employee_dob_certificate', $todayMonth)
                            ->whereDay('epi.employee_dob_certificate', $todayDay);
                    });

            })
            ->select('employees.*')
            ->get();

        foreach ($employees as $employee) {
            SendBirthdayMailJob::dispatch($employee)->onQueue('birthday');
        }
    }
}
