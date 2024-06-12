<?php

namespace App\Models\Access\User;

use Illuminate\Database\Eloquent\Model;

class PasswordHistory extends Model
{

    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(User::class);
    }
}