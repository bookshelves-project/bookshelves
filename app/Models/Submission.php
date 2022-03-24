<?php

namespace App\Models;

use App\Enums\SubmissionReasonEnum;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'name',
        'email',
        'reason',
        'message',
    ];

    protected $casts = [
        'reason' => SubmissionReasonEnum::class,
    ];
}
