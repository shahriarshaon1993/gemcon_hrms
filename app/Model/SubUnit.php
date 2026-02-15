<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Spatie\Activitylog\Traits\LogsActivity;
// 202221063056  r1a11p21
class SubUnit extends Model
{
    use LogsActivity;
   protected $table = 'sub_units';

    protected $guarded = array('id','created_at','updated_at');
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['created','updated','deleted'];
    protected static $logName = 'Sub Unit';
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }

    public function scopeValid($query)
	{
			return $query->where('sub_units.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('sub_units.project_id', $project_id);
    }   
}