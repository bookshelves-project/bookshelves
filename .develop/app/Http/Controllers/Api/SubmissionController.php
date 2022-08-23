<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SubmissionRequest;
use App\Models\Submission;
use App\Notifications\SubmissionNotification;
use Illuminate\Support\Facades\Notification;

/**
 * @group Submission
 */
class SubmissionController extends ApiController
{
    /**
     * POST Send submission.
     *
     * If `honeypot` is `true`, submission will be not sended.
     */
    public function create(SubmissionRequest $request)
    {
        $validated = $request->validated();

        if (! $validated['honeypot']) {
            $submission = Submission::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'message' => $validated['message'],
            ]);

            Notification::route('mail', [config('mail.to.address') => config('mail.to.name')])
                ->notify(new SubmissionNotification($submission))
            ;
        }

        return response()->json([
            'message' => 'Your mail was sended!',
            'honeypot' => $validated['honeypot'],
        ], 200);
    }
}
