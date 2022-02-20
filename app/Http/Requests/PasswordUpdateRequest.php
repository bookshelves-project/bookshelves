<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest
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
            'current_password' => 'required|string|max:256|current_password',
            'password' => 'required|string|max:256|confirmed',
        ];
    }

    public function bodyParameters()
    {
        return [
            'current_password' => [
                'description' => '',
                'example' => 'sunt-commodo-ipsum-aliqua',
            ],
            'password' => [
                'description' => '',
                'example' => 'ea-occaecat-culpa-ut-pariatur',
            ],
        ];
    }
}
