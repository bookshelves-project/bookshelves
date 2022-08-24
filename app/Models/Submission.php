<?php

namespace App\Models;

use App\Enums\SubmissionReasonEnum;
use App\Traits\HasAttachment;
use App\Traits\Mediable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;
    use HasAttachment;
    use Mediable;

    protected $fillable = [
        'name',
        'email',
        'reason',
        'message',
    ];

    protected $appends = [
        // 'attachment_file',
    ];

    protected $casts = [
        'reason' => SubmissionReasonEnum::class,
    ];

    // public function getAttachmentFileAttribute()
    // {
    //     return $this->cv
    //         ? config('app.url')."/storage{$this->cv}"
    //         : null;
    // }
}
