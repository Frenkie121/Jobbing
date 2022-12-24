<?php

namespace App\Notifications;

use App\Models\{Freelance, Job};
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SelectApplicantNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        protected Job $job,
        protected Freelance $freelance,
        protected bool $selected,
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
        $selection = $this->selected ? 'selected' : 'unselected';
        return (new MailMessage)
                        ->subject("Job Applicant Alert")
                        ->greeting("Hello {$notifiable->name},")
                        ->when($notifiable->role_id === 2, fn(MailMessage $mail)
                            => $mail->line("You have {$selection} {$this->freelance->user->name} for job {$this->job->title}.")
                        )
                        ->when($notifiable->role_id === 3, fn(MailMessage $mail) 
                            => $mail->line("You have been {$selection} for job {$this->job->title}.")
                        )
                        ->action('Go to Dashboard', $notifiable->role_id === 2 ? route('customer.index') : route('freelance.index'))
                        ->line('Thank you for using Jobbing!');;
    }
}
