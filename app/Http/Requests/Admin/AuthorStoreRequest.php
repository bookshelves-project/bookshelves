<?php

namespace App\Http\Requests\Admin;

use App\Enums\AuthorRoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Enum\Laravel\Rules\EnumRule;

class AuthorStoreRequest extends FormRequest
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
            'firstname' => ['required'],
            'lastname' => ['required'],
            'name' => ['nullable'],
            'role' => new EnumRule(AuthorRoleEnum::class),
            'description' => ['nullable'],
            'link' => ['nullable'],
            'note' => ['nullable'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'name' => "{$this->firstname} {$this->lastname}",
        ]);
    }
}
