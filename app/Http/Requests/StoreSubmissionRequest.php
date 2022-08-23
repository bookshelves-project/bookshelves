<?php

namespace App\Http\Requests;

use App\Enums\ContactSubjectEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreSubmissionRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'subject' => [new Enum(ContactSubjectEnum::class)],
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'society' => 'nullable|string',
            'message' => 'required|string',
            'accept_conditions' => 'required|boolean',
            'want_newsletter' => 'boolean',
            'cv' => 'mimetypes:application/pdf|max:10000',
            'letter' => 'mimetypes:application/pdf|max:10000',
            'honeypot' => 'required|boolean',
        ];
    }
}
