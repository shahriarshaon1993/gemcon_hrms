<?php

namespace App\Jobs;

use App\Mail\SendBirthdayMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendBirthdayMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employee;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        // $this->employee->employee_email
        // $this->employee->official_email_id
        // shahriar.shaon@gemcongroup.com
        // faruk.khan@gemcongroup.com
        try {
            if ($this->employee->official_email_id) {
                Mail::to($this->employee->official_email_id)
                    ->send(new SendBirthdayMail($this->employee));
            } elseif ($this->employee->employee_email) {
                Mail::to($this->employee->employee_email)
                    ->send(new SendBirthdayMail($this->employee));
            } else {
                $messageText = 'Birthday mail not found for Employee ID: ' . $this->employee->employee_id_no;

                Mail::raw($messageText, function ($message) {
                    $message->to('gemcon@gmail.com')
                        ->subject("Birthday Mail Missing: {$this->employee->employee_id_no}");
                });
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        } finally {
            app()->forgetInstance('mailer');
        }
    }
}
