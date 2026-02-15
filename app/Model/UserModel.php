<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
	use Notifiable;

    protected $guard ='user';
    
    protected $table = 'users';

    protected $guarded = array('id', 'created_at', 'updated_at');

    public function scopeValid($query)
    {
        return $query->where('users.valid', 1);
    }
}
