<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileDelete extends FormRequest
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
            'confirm' => 'required|boolean',
        ];
    }

    public function bodyParameters()
    {
        return [
            'current_password' => [
                'description' => '',
                'example' => 'et-aliquip',
            ],
            'confirm' => [
                'description' => '',
                'example' => true,
            ],
        ];
    }
}
