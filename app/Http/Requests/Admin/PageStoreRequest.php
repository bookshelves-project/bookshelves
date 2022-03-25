<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PageStoreRequest extends FormRequest
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
            'title' => ['required'],
            'slug' => ['nullable'],
            'summary' => ['nullable'],
            'body' => ['nullable'],
            'published_at' => ['nullable', 'date'],
            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
            'featured_image_file' => ['nullable', 'image'],
            'featured_image_delete' => ['boolean'],
        ];
    }
}
