<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class AttendanceIssue extends Model
{
   protected $table = 'attendance_issues';

    protected $guarded = array('id','created_at','updated_at');

    public function scopeValid($query)
	{
			return $query->where('attendance_issues.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('attendance_issues.project_id', $project_id);
    }   
}