<?php

namespace App\Jobs;

use App\Helper\Helper;
use App\Mail\AttendanceReminderMail;
use App\Model\Attendance;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendAttendanceMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employee;
    protected $fromDate;
    protected $toDate;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($employee, $fromDate, $toDate)
    {
        $this->employee = $employee;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        if (!$this->employee->official_email_id) return;

        $totalDays = Carbon::parse($this->fromDate)
                ->diffInDays(Carbon::parse($this->toDate)) + 1;

        $query = Attendance::query()
            ->where('employee_card_no', $this->employee->employee_id_no)
            ->whereBetween('pdate', [$this->fromDate, $this->toDate]);

        $attendances = $query->get();

        $countEarlyOut = 0;

        foreach ($attendances as $attendance) {
            if (Helper::isEarlyOut($attendance)) {
                $countEarlyOut++;
            }
        }

        $attendanceStatus = [
            'total_early_out' => $countEarlyOut,
            'present' => $attendances->where('pstatus', 1)->count(),
            'late_present' => $attendances->where('pstatus', 2)->count(),
            'total_absent' => $attendances->where('pstatus', 3)->count(),
            'total_leave' => $attendances->where('pstatus', 6)->count(),
            'total_late_approve' => $attendances
                ->where('remarks', 'Late(Approved)')
                ->where('pstatus', 1)->count(),
        ];

        // $this->employee->official_email_id
        // shahriar.shaon@gemcongroup.com

        try {
            Mail::to($this->employee->official_email_id)->send(
                new AttendanceReminderMail(
                    $this->employee,
                    $attendances,
                    $totalDays,
                    $attendanceStatus
                )
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        } finally {
            app()->forgetInstance('mailer');
        }
    }
}
