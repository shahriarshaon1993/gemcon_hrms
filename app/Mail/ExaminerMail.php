<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExaminerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    
         return $this->view('emails.examiner_mail')
                ->subject("Greetings! You are one of the examiner.")
                ->with([
                    'name' => $this->user['full_name'],
                    'email' => $this->user['email'],
                    'email_body' => $this->user['email_body'],
                    'access_link' => $this->user['access_link'],
                ]);
    }
}
