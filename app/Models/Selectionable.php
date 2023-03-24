<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Selectionable extends Model
{
    use HasFactory;

    protected $fillable = [
        'selection_id',
        'selectionable_id',
        'selectionable_type',
    ];

    public function selectionable(): MorphTo
    {
        return $this->morphTo();
    }
}
