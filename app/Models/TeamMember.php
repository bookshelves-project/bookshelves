<?php

namespace App\Models;

use App\Traits\Mediable;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class TeamMember extends Model
{
    use HasFactory;
    use Mediable;
    use Sortable;

    public $appends = [
        'full_name',
    ];

    protected $fillable = [
        'firstname',
        'lastname',
        'slug',
        'function',
        'image',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->lastname} {$this->firstname}";
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function (TeamMember $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug("{$model->firstname} {$model->lastname}");
            }
        });
    }
}
