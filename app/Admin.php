<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\AdminNotification;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id';

    protected $guard = 'admin';

    protected $fillable = [
        'username', 'password', 'name', 'profile_image', 'phone', 'created_at', 'updated_at'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function notifications(){
        return $this->morphMany(AdminNotification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

}
