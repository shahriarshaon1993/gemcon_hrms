<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
// use Illuminate\Contracts\Queue\ShouldQueue;

class OtpMail extends Mailable
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
        return $this->view('emails.otp_email')
            ->subject("OTP for email varification.")
            ->from('noreply@gmail.com', 'HRIS')
            ->with([
                'name' => '',
                'email' => $this->user['email'],
                'email_body' => '',
                'otp' => $this->user['otp'],
        ]);
    }
}
