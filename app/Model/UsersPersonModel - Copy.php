<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class UsersPersonModel extends Authenticatable
{
   protected $table = 'users_person';

    protected $guarded = array('id','created_at','updated_at');

    public function scopeValid($query)
    {
            return $query->where('users_person.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('users_person.project_id', $project_id);
    }   
}