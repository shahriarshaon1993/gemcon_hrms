<?php

namespace App\Notifications;
use Auth;
use App\Model\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ServiceRequestNotifi extends Notification implements ShouldBroadcast
{
    use Queueable;
    public $serviceRequestData;
    // public $data;
    // public $send_to;
    // public $send_from;
    // public $n_type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $serviceRequestData)
    {
       $this->serviceRequestData = $serviceRequestData;
    //    $this->data = $data;
    //    $this->send_to = $send_to;
    //    $this->send_from = $send_from;
    //    $this->n_type = $n_type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable):array
    {
        // return ['mail'];
        return ['database','broadcast'];
        
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'serviceRequestData'=> $this->serviceRequestData,
            'admin'=> $notifiable
        ];
    }
    public function toBroadcast($notifiable):BroadcastMessage
    {
        
        return new BroadcastMessage([
            'notification'=> $notifiable->notifications()->latest()->first()
        ]);
        // return new BroadcastMessage([
        //     'message' => "$this->message (User $notifiable->id)"
        // ]);
    }

}
