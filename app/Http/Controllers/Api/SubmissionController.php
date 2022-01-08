<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SubmissionRequest;
use App\Mail\SubmissionMail;
use App\Models\Submission;
use Mail;

/**
 * @group Misc
 */
class SubmissionController extends ApiController
{
    /**
     * POST Send submission.
     */
    public function send(SubmissionRequest $request)
    {
        $validated = $request->validated();

        // honeypot fake response
        if ($validated['honeypot']) {
            return response()->json([
                'success' => 'Your mail was sended!',
            ], 200);
        }

        // Create model
        $submission = Submission::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
        ]);

        $from_address = config('mail.from.address');

        // Send mail
        Mail::send(new SubmissionMail(submission: $submission));

        return response()->json([
            'success' => 'Your mail was sended!',
            'contact' => [
                'from' => $from_address,
            ],
        ], 200);
    }
}
