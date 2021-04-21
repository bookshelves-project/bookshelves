<?php

namespace App\Http\Controllers\Api;

use Mail;
use App\Models\Submission;
use App\Mail\SubmissionMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubmissionController extends Controller
{
    public function send(Request $request)
    {
        $validate = $this->validate($request, [
            'name'                  => 'required|string',
            'email'                 => 'required|email:rfc,strict,dns,filter',
            'message'               => 'required|string|min:50',
        ]);

        // Create model
        $submission = Submission::create([
            'name'    => $validate['name'],
            'email'   => $validate['email'],
            'message' => $validate['message'],
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
