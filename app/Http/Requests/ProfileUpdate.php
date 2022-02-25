<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ProfileUpdate extends FormRequest
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
            'name' => 'required|string|max:256',
            'email' => 'required|email:rfc,strict,dns,filter',
            'about' => 'nullable|string|max:2048',
            'avatar' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048|file',
            'banner' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048|file',
            'use_gravatar' => 'required|boolean',
            'display_favorites' => 'required|boolean',
            'display_comments' => 'required|boolean',
            'display_gender' => 'required|boolean',
            'gender' => [new Enum(GenderEnum::class)],
        ];
    }

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => '',
                'example' => 'username',
            ],
            'email' => [
                'description' => '',
                'example' => 'user@mail.com',
            ],
            'about' => [
                'description' => '',
                'example' => 'Nostrud consequat occaecat dolore id ipsum culpa duis reprehenderit incididunt aute enim sint cillum Lorem. Non qui irure veniam eiusmod dolore mollit elit labore cupidatat eiusmod quis reprehenderit velit ut. Laborum culpa eiusmod laborum nostrud enim dolore incididunt. Consectetur cillum Lorem quis magna magna aliqua duis ut.',
            ],
            'use_gravatar' => [
                'description' => '',
                'example' => true,
            ],
            'display_favorites' => [
                'description' => '',
                'example' => true,
            ],
            'display_comments' => [
                'description' => '',
                'example' => true,
            ],
            'display_gender' => [
                'description' => '',
                'example' => true,
            ],
            'gender' => [
                'description' => '',
                'example' => 'unknown',
            ],
        ];
    }
}
