<?php

namespace App\Mail;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmissionMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        public Submission $submission,
    ) {
    }

    /**
     * Build the message.
     *
     * @return Mailable
     */
    public function build(): Mailable
    {
        /** @var Mailable $mail */
        $mail = $this;

        $subject = '[Bookshelves] Contact from ' . $this->submission->name;
        $from_address = config('mail.from.address');
        $from_name = config('mail.from.name');
        $to_address = config('mail.to.address');
        $to_name = config('mail.to.name');

        return $mail->to($to_address, $to_name)
            ->from($from_address, $from_name)
            ->subject($subject)
            ->markdown('emails.submission')
            ->with([
                'name'       => $this->submission->name,
                'email'      => $this->submission->email,
                'message'    => $this->submission->message,
            ]);
    }
}
