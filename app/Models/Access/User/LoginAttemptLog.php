<?php

namespace App\Models\Access\User;

use Illuminate\Database\Eloquent\Model;

class LoginAttemptLog extends Model
{
    protected $guarded = [];
    protected $table = 'login_attempts_logs';


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
