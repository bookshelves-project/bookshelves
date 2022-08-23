<?php

namespace App\Models;

use App\Enums\ContactSubjectEnum;
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
        'subject',
        'name',
        'email',
        'phone',
        'society',
        'message',
        'accept_conditions',
        'want_newsletter',
        'cv',
        'letter',
    ];

    protected $appends = [
        'cv_file',
        'lm_file',
    ];

    protected $casts = [
        'subject' => ContactSubjectEnum::class,
        'accept_conditions' => 'boolean',
        'want_newsletter' => 'boolean',
    ];

    public function getCvFileAttribute()
    {
        return $this->cv
            ? config('app.url')."/storage{$this->cv}"
            : null;
    }

    public function getLmFileAttribute()
    {
        return $this->letter
            ? config('app.url')."/storage{$this->letter}"
            : null;
    }
}
