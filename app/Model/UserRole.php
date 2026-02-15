<?php

namespace App\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class UserRole extends BaseModel
{
    use LogsActivity;
    protected $table = 'user_roel';

    protected $guarded = array('id', 'created_at', 'updated_at');
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['created','updated','deleted'];
    protected static $logName = 'UserRole';
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }
    

    public static function boot()
    {
        parent::adminBoot();
    }

    public function scopeValid($query)
    {
        return $query->where('user_roel.valid', 1);
    }


}
