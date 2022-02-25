<?php

namespace App\Http\Requests\Admin;

use App\Enums\PostStatusEnum;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Enum\Laravel\Rules\EnumRule;

class PostStoreRequest extends FormRequest
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
            'status' => new EnumRule(PostStatusEnum::class),
            'category_id' => ['required', Rule::exists(PostCategory::class, 'id')],
            'user_id' => ['required', Rule::exists(User::class, 'id')],
            'summary' => ['nullable'],
            'body' => ['nullable'],
            'published_at' => ['nullable', 'date'],
            'pin' => ['boolean'],
            'promote' => ['boolean'],
            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
            'tags' => ['array'],
            'featured_image_file' => ['nullable', 'image'],
            'featured_image_delete' => ['boolean'],
        ];
    }

    public function prepareForValidation()
    {
        if (! $this->user_id) {
            $this->merge([
                'user_id' => Auth::id(),
            ]);
        }

        if (! $this->tags) {
            $this->merge([
                'tags' => [],
            ]);
        }

        $status = PostStatusEnum::draft();
        $publishedAt = $this->published_at;

        if ($this->publish) {
            if ($publishedAt) {
                $status = Carbon::parse($publishedAt) > Carbon::now()
                    ? PostStatusEnum::scheduled()
                    : PostStatusEnum::published();
            }

            if (! $publishedAt) {
                $publishedAt = Carbon::now()->setSecond(0);
                $status = PostStatusEnum::published();
            }
        }

        $this->merge([
            'status' => $status,
            'published_at' => $publishedAt,
        ]);
    }
}
