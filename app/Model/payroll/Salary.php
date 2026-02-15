<?php
namespace App\Model\payroll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class Salary extends Model
{
    use LogsActivity;
    protected $table = 'salaries';
    protected $guarded = array('id','created_at','updated_at');
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['created','updated','deleted'];
    protected static $logName = 'Employee Salary';
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }


    public function scopeValid($query)
	{
			return $query->where('salaries.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('salaries.project_id', $project_id);
    }   
}