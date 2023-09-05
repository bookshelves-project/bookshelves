<?php

namespace App\Models;

use App\Enums\SubmissionReasonEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kiwilan\Steward\Traits\HasAttachment;
use Kiwilan\Steward\Traits\Mediable;

class Submission extends Model
{
    use HasAttachment;
    use HasFactory;
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
