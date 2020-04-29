<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    // Социальный аккаунт принадлежит одному пользователю
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
