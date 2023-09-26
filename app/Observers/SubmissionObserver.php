<?php

namespace App\Observers;

use App\Models\Submission;
use App\Notifications\SubmissionNotification;
use Notification;

class SubmissionObserver
{
    /**
     * Handle the Submission "created" event.
     */
    public function created(Submission $submission)
    {
        $recipient = [
            config('mail.recipients.default.address') => config('mail.recipients.default.name'),
        ];
        Notification::route('mail', $recipient)
            ->notify(new SubmissionNotification($submission));
    }
}
