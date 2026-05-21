<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBirthdayMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Warm Birthday Wishes from {$this->employee->sbu->sbu_name}";

        return $this->view('emails.birthday_mail')
            ->subject($subject)
            ->from('noreply.gemcon@gmail.com', 'HRIS')
            ->with(['employee' => $this->employee]);
    }
}
