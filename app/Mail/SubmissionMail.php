<?php

namespace App\Mail;

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
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = '[Bookshelves] Contact from '.$this->data['name'];
        $to = config('bookshelves.mails.to');
        $from = config('mail.from.address');

        return $this->to($to)
            ->from($from)
            ->subject($subject)
            ->markdown('emails.submission')
            ->with([
                'name'       => $this->data['name'],
                'email'      => $this->data['email'],
                'message'    => $this->data['message'],
            ]);
    }
}
