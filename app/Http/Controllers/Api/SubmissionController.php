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
            'email'                 => 'required|email',
            'message'               => 'required|string',
            'g-recaptcha-response'  => 'required|recaptcha',
        ]);

        // Create model
        $submission = Submission::create([
            'name'    => $validate['name'],
            'email'   => $validate['email'],
            'message' => $validate['message'],
        ]);
        // Send mail
        Mail::send(new SubmissionMail(submission: $submission));

        return response()->json([
            'success' => 'Your mail was sended!',
        ], 200);
    }
}
