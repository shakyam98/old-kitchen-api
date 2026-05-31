<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    public const PURPOSE_LOGIN = 'login';

    public const PURPOSE_REGISTER = 'register';

    public const PURPOSE_RESET_PASSWORD = 'reset_password';

    protected $table = 'otp';

    protected $fillable = [
        'mobile',
        'otp_code',
        'purpose',
        'otp_expires_at',
        'is_verified',
    ];

    protected $casts = [
        'otp_expires_at' => 'datetime',
        'is_verified' => 'boolean',
    ];
}
