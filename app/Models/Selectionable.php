<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selectionable extends Model
{
    use HasFactory;

    protected $fillable = [
        'selection_id',
        'selectionable_id',
        'selectionable_type',
    ];

    public function selectionable()
    {
        return $this->morphTo();
    }
}
