<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AttendanceReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $totalDays;
    public $attendances;
    public $attendanceStatus;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employee, $attendances, $totalDays, $attendanceStatus)
    {
        $this->employee = $employee;
        $this->totalDays = $totalDays;
        $this->attendances = $attendances;
        $this->attendanceStatus = $attendanceStatus;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Attendance record of {$this->employee->employee_fullname}";

        return $this->view('emails.attendance_reminder_mail')
            ->subject($subject)
            ->from('noreply.gemcon@gmail.com', 'HRIS')
            ->with([
                'employee' => $this->employee,
                'attendances' => $this->attendances,
                'totalDays' => $this->totalDays,
                'attendanceStatus' => $this->attendanceStatus
            ]);
    }
}
