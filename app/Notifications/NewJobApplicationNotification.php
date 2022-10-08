<?php

namespace App\Notifications;

use App\Models\{Freelance, Job};
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewJobApplicationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        public Job $job, 
        public ?Freelance $freelance = null,
    ){}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("New Job Application")
                    ->greeting("Hello {$notifiable->name},")
                    ->when($notifiable->role_id === 2, fn(MailMessage $mail)
                        => $mail->line("There is a new application for job {$this->job->title} from {$this->freelance->user->name}.")
                    )
                    ->when($notifiable->role_id === 3, fn(MailMessage $mail) 
                        => $mail->line("You have successfully applied for job {$this->job->title}.")
                    )
                    ->action('Go to Dashboard', $notifiable->role_id === 2 ? route('customer.index') : route('freelance.index'))
                    ->line('Thank you for using Jobbing!');
    }
}
