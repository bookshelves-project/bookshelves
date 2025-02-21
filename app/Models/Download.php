<?php

namespace App\Models;

use App\Enums\BookFormatEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'user_agent',
        'name',
        'format',
        'is_series',
    ];

    protected $casts = [
        'format' => BookFormatEnum::class,
        'size' => 'integer',
        'is_series' => 'boolean',
    ];

    public static function generate(Request $request, Book|Serie $model): self
    {
        /** @var ?Download */
        $download = Download::query()->create([
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($model instanceof Serie) {
            $model->append('format');
            $download->serie()->associate($model);
        } else {
            $download->book()->associate($model);
        }

        $download->name = $download->createTitle($model);
        $authors = $model->authors->pluck('name')->implode(', ');
        $download->authors = strlen($authors) > 255 ? substr($authors, 0, 252).'...' : $authors;
        $download->is_series = $model instanceof Serie;
        $download->format = $model->format;

        $download->library()->associate($model->library);

        if (Auth::check()) {
            $download->user()->associate(Auth::user());
        }

        $download->save();

        return $download;
    }

    public function createTitle(Book|Serie $model): string
    {
        if ($model instanceof Book) {
            if ($model->serie) {
                return "{$model->serie->title} #{$model->volume_pad} {$model->title}";
            }

            return "{$model->title}";
        }

        return "{$model->title}";
    }

    public function file(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function serie(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Serie::class);
    }

    public function library(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Library::class);
    }
}
