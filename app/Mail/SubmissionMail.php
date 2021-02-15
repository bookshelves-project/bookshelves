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
    ) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = '[Bookshelves] Contact from '.$this->submission->name;
        $to = config('bookshelves.mails.to');
        $from = config('mail.from.address');

        return $this->to($to)
            ->from($from)
            ->subject($subject)
            ->markdown('emails.submission')
            ->with([
                'name'       => $this->submission->name,
                'email'      => $this->submission->email,
                'message'    => $this->submission->message,
            ]);
    }
}
