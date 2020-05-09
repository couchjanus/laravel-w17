<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Notifications\AdminResetPasswordNotification as Notification;
// use App\Notifications\AdminEmailVerificationNotification;

class Admin extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    
    protected $guard = 'admin';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_super',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function isSuperAdmin()
    {
        return $this->is_super;
    }

    public static function scopeTrash($query, $id)
    {
        return $query->withTrashed()->where('id', $id)->first();       
    }

    static function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_role');
    }
}
