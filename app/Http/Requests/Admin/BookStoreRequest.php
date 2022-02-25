<?php

namespace App\Http\Requests\Admin;

use App\Enums\BookTypeEnum;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Serie;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class BookStoreRequest extends FormRequest
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
            'title' => ['nullable'],
            'slug_sort' => ['nullable'],
            'slug' => ['nullable'],
            'contributor' => ['nullable'],
            'description' => ['nullable'],
            'released_on' => ['nullable', 'date'],
            'rights' => ['nullable'],
            'volume' => ['nullable', 'integer'],
            'page_count' => ['nullable', 'integer'],
            'maturity_rating' => ['nullable'],
            'disabled' => ['boolean'],
            'type' => [new Enum(BookTypeEnum::class)],
            'tags' => ['array'],
            'cover_file' => ['nullable', 'image'],
            'cover_delete' => ['boolean'],
            'publisher_id' => ['nullable', Rule::exists(Publisher::class, 'id')],
            'serie_id' => ['nullable', Rule::exists(Serie::class, 'id')],
            'language_slug' => ['nullable', Rule::exists(Language::class, 'slug')],
            'authors' => ['array'],
        ];
    }

    public function prepareForValidation()
    {
        // if (! $this->user_id) {
        //     $this->merge([
        //         'user_id' => Auth::id(),
        //     ]);
        // }

        if (! $this->authors) {
            $this->merge([
                'authors' => [],
            ]);
        }
        if (! $this->tags) {
            $this->merge([
                'tags' => [],
            ]);
        }

        $type = BookTypeEnum::novel;
        // $publishedAt = $this->published_at;

        // if ($this->publish) {
        //     if ($publishedAt) {
        //         $type = Carbon::parse($publishedAt) > Carbon::now()
        //             ? PostStatusEnum::scheduled
        //             : PostStatusEnum::published;
        //     }

        //     if (! $publishedAt) {
        //         $publishedAt = Carbon::now()->setSecond(0);
        //         $type = PostStatusEnum::published;
        //     }
        // }

        // $this->merge([
        //     'type' => $type,
        //     'published_at' => $publishedAt,
        // ]);
    }
}
