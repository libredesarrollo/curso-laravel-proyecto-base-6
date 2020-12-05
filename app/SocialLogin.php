<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialLogin extends Model
{
    protected $fillable = ['user_id', 'provider', 'nick_email', 'social_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
