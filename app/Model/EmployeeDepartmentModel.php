<?php

namespace App\Model;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EmployeeDepartmentModel extends Model
{
    use LogsActivity;
    protected $table = 'departments';

    protected $guarded = array('id','created_at','updated_at');

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['created','updated','deleted'];
    protected static $logName = 'Employee Department';
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }

    public function scopeValid($query)
	{
			return $query->where('departments.valid', 1);
    }
    // public function scopeProject($query)
    // {
    //     $project_id = Auth::guard('user')->user()->project_id;
    //     return $query->where('employee_department.project_id', $project_id);
    // }
}
