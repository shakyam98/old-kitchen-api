<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'first_name',
        'last_name',
        'mobile',
        'password',
        'user_type_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function userType(): BelongsTo
    {
        return $this->belongsTo(UserType::class);
    }
}
