<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'user_agent',
        'name',
        'type',
        'ulid_id',
        'ulid_table',
    ];

    public static function generate(Request $request, Book|Serie $model): self
    {
        $download = Download::query()->create([
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $download->setType($model);
        $download->name = $download->createName($model);
        $download->saveQuietly();

        return $download;
    }

    public function createName(Book|Serie $model): string
    {
        $name = 'unknown';
        if ($model instanceof Book) {
            if ($model->serie) {
                $name = "{$model->serie->title} {$model->volume_pad}";
            }

            $name .= " {$model->title} by {$model->authorMain->name} from ({$model->library->name})";

            return trim($name);
        }

        return "{$model->title}'s series by {$model->authorMain->name} from ({$model->library->name})";
    }

    public function setType(Book|Serie $model): void
    {
        $this->type = $model instanceof Book ? 'App\Models\Book' : 'App\Models\Serie';
        $this->ulid_id = $model->id;
        $this->ulid_table = $model instanceof Book ? 'books' : 'series';
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
