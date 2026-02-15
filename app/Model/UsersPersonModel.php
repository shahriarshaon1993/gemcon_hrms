<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class UsersPersonModel extends Authenticatable
{
    use LogsActivity;
   protected $table = 'users_person';

    protected $guarded = array('id','created_at','updated_at');
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['created','updated','deleted'];
    protected static $logName = 'Users Person';
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }


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