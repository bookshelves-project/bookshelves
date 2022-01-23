<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PasswordReset extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $primaryKey = 'email';
    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
    ];

    public static function boot()
    {
        static::saving(function (PasswordReset $passwordReset) {
            $passwordReset->created_at = Carbon::now();
        });

        parent::boot();
    }
}
