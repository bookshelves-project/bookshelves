<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Enum\Laravel\Rules\EnumRule;

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
            'email' => 'required|email|max:256',
            'about' => 'nullable|string|max:2048',
            'avatar' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'banner' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'use_gravatar' => 'required|boolean',
            'display_favorites' => 'required|boolean',
            'display_comments' => 'required|boolean',
            'display_gender' => 'required|boolean',
            'gender' => new EnumRule(GenderEnum::class),
        ];
    }
}
