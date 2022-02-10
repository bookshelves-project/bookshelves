<?php

namespace App\Http\Requests\Admin;

use App\Enums\BookTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Enum\Laravel\Rules\EnumRule;

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
            // 'title' => ['required'],
            // 'slug' => ['nullable'],
            // 'status' => new EnumRule(PostStatusEnum::class),
            // 'category_id' => ['required', Rule::exists(PostCategory::class, 'id')],
            // 'user_id' => ['required', Rule::exists(User::class, 'id')],
            // 'summary' => ['nullable'],
            // 'body' => ['nullable'],
            // 'published_at' => ['nullable', 'date'],
            // 'pin' => ['boolean'],
            // 'promote' => ['boolean'],
            // 'meta_title' => ['nullable'],
            // 'meta_description' => ['nullable'],
            // 'tags' => ['array'],
            // 'featured_image_file' => ['nullable', 'image'],
            // 'featured_image_delete' => ['boolean'],
            'title' => ['required'],
            'slug_sort' => ['nullable'],
            'slug' => ['nullable'],
            'contributor' => ['nullable'],
            'description' => ['nullable'],
            'released_on' => ['required', 'date'],
            'rights' => ['nullable'],
            'volume' => ['nullable', 'integer'],
            'page_count' => ['nullable', 'integer'],
            'maturity_rating' => ['nullable'],
            'disabled' => ['boolean'],
            'type' => new EnumRule(BookTypeEnum::class),
        ];
    }

    public function prepareForValidation()
    {
        // if (! $this->user_id) {
        //     $this->merge([
        //         'user_id' => Auth::id(),
        //     ]);
        // }

        if (! $this->tags) {
            $this->merge([
                'tags' => [],
            ]);
        }

        $status = BookTypeEnum::novel();
        // $publishedAt = $this->published_at;

        // if ($this->publish) {
        //     if ($publishedAt) {
        //         $status = Carbon::parse($publishedAt) > Carbon::now()
        //             ? PostStatusEnum::scheduled()
        //             : PostStatusEnum::published();
        //     }

        //     if (! $publishedAt) {
        //         $publishedAt = Carbon::now()->setSecond(0);
        //         $status = PostStatusEnum::published();
        //     }
        // }

        // $this->merge([
        //     'status' => $status,
        //     'published_at' => $publishedAt,
        // ]);
    }
}
