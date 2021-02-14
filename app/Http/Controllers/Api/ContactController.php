<?php

namespace App\Http\Controllers\Api;

use Mail;
use App\Models\Contact;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validate = $this->validate($request, [
            'name'                  => 'required|string',
            'email'                 => 'required|email',
            'message'               => 'required|string',
            // 'g-recaptcha-response' => 'required|recaptcha',
        ]);

        $email = Contact::create([
            'name'    => $validate['name'],
            'email'   => $validate['email'],
            'message' => $validate['message'],
        ]);
        Mail::send(new ContactMail($email));

        return response()->json([
            'success' => 'Your mail was sended!',
        ], 200);
    }
}
