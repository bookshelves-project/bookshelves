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
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $appName = config('app.name');
        $with_newsletter = $this->submission->want_newsletter ? 'accepte de recevoir la newsletter' : null;
        $with_cv = $this->submission->cv ? 'a joint son CV' : null;
        $with_letter = $this->submission->letter ? 'a joint sa lettre de motivation' : null;

        $more = [$with_newsletter, $with_cv, $with_letter];
        $more = array_filter($more);
        $more = implode(', ', $more);

        $cv = $this->submission->cv ? public_path("storage{$this->submission->cv}") : null;
        $letter = $this->submission->letter ? public_path("storage{$this->submission->letter}") : null;

        $mail = (new MailMessage())
            ->subject("[{$appName}] {$this->submission->subject->value} - {$this->submission->name}")
            ->greeting('Bonjour,')
            ->line("Vous avez reçu un nouveau message de la part de {$this->submission->name}.")
            ->lines([
                "Sujet : {$this->submission->subject->value}",
                "Nom : {$this->submission->name}",
                "Email: {$this->submission->email}",
                "Téléphone : {$this->submission->phone}",
                "Société : {$this->submission->society}",
                'Message :',
                $this->submission->message,
                ucfirst($more),
            ])
            ->action('Voir sur le back-office', route('filament.resources.submissions.index'))
            ->line('Cordialement,')
            ->salutation("L'équipe {$appName}")
        ;

        if ($cv) {
            $mail->attach($cv);
        }
        if ($letter) {
            $mail->attach($letter);
        }

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'submission' => $this->submission->toArray(),
            'with_files' => true,
        ];
    }
}
