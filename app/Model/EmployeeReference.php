<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class EmployeeReference extends Model
{
    use LogsActivity;
    protected $table = 'employee_references';

    protected $guarded = array('id','created_at','updated_at');
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['created','updated','deleted'];
    protected static $logName = 'Employee Reference';
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }

    public function scopeValid($query)
	{
			return $query->where('employee_references.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('employee_references.project_id', $project_id);
    }
}
