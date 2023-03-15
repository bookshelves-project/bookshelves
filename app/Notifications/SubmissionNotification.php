<?php

namespace App\Notifications;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubmissionNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Submission $submission
    ) {
    }

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
        $appName = config('app.name');

        return (new MailMessage())
            ->subject("[{$appName}] {$this->submission->reason->value} - {$this->submission->name}")
            ->greeting('Hello,')
            ->line("You have a new message from {$this->submission->name}.")
            ->lines([
                "Name: {$this->submission->name}",
                "Email: {$this->submission->email}",
                "Reason: {$this->submission->reason->value}",
                'Message:',
                $this->submission->message,
            ])
            ->action('Check on dashboard', route('filament.resources.submissions.index'))
            ->line('Regards,')
            ->salutation("{$appName} team")
        ;
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
            'submission' => $this->submission->toArray(),
        ];
    }
}
