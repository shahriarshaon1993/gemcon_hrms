<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminModel extends Authenticatable
{
	use Notifiable;

    protected $guard ='admin';

    protected $table = 'admins';

    protected $guarded = array('id', 'created_at', 'updated_at','comment');

    public function scopeValid($query)
    {
        return $query->where('admins.valid', 1);
    }
}
