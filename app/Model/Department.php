<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Auth;

class Department extends Model
{
    // use \OwenIt\Auditing\Auditable;
    use LogsActivity;
    protected $table = 'departments';

    protected $guarded = array('id','created_at','updated_at');
    protected static $logAttributes = ['department_name', 'department_status', 'department_code', 'department_head', 'priority' ];
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['created','updated','deleted'];
    protected static $logName = 'Department';
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }
    public function scopeValid($query)
    {
        return $query->where('departments.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('departments.project_id', $project_id);
    }
    public function employees()
    {
        return $this->hasMany('App\Model\Employee', 'employee_department');
    }
}
