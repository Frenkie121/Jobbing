<?php

namespace App\Notifications;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LaunchJobNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        protected Job $job,
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
                    ->subject("Job Launched")
                    ->greeting("Hello {$notifiable->name},")
                    ->when($notifiable->role_id === 2, fn(MailMessage $mail)
                        => $mail->line("You have just launched the job {$this->job->title}.")
                    )
                    ->when($notifiable->role_id === 3, fn(MailMessage $mail) 
                        => $mail->line("The job {$this->job->title} has just started.")
                    )
                    ->action('Go to Dashboard', $notifiable->role_id === 2 ? route('customer.index') : route('freelance.index'))
                    ->line('Thank you for using Jobbing!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
