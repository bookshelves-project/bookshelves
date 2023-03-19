<?php

namespace App\Http\Requests;

use App\Enums\SubmissionReasonEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SubmissionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'reason' => [new Enum(SubmissionReasonEnum::class)],
            'honeypot' => 'required|boolean',
            'message' => 'required|string|min:15',
        ];
    }

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => "User's name",
                'example' => 'Name',
            ],
            'email' => [
                'description' => "User's email",
                'example' => 'user@email.com',
            ],
            'honeypot' => [
                'description' => 'Honeypot: must be false to send notification',
                'example' => 1,
            ],
            'message' => [
                'description' => "User's message",
                'example' => 'Hello! This is a message for you!',
            ],
        ];
    }
}
