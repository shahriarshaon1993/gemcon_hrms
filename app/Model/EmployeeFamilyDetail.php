<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Spatie\Activitylog\Traits\LogsActivity;


class EmployeeFamilyDetail extends Model
{
    use LogsActivity;
    protected $table = 'employee_family_details';

    protected $guarded = array('id','created_at','updated_at');
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['created','updated','deleted'];
    protected static $logName = 'Employee Family Detail';
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }

    public function scopeValid($query)
	{
			return $query->where('employee_family_details.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('employee_family_details.project_id', $project_id);
    }
}
