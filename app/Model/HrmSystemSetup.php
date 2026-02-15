<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class HrmSystemSetup extends Model
{
    use LogsActivity;
   protected $table = 'hrm_system_setups';

    protected $guarded = array('id','created_at','updated_at');
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['created','updated','deleted'];
    protected static $logName = 'HrmSystemSetup';
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }

    public function scopeValid($query)
	{
			return $query->where('hrm_system_setups.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('hrm_system_setups.project_id', $project_id);
    }   
}