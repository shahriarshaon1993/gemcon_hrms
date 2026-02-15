<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class HrStationarySummaryPos extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'hr_stationary_summary';

    protected $guarded = array('id','created_at','updated_at');

    public function scopeValid($query)
	{
		return $query->where('hr_stationary_summary.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('hr_stationary_summary.project_id', $project_id);
    }   
   
    public function employees()
    {       
        return  $this->belongsToMany(Employee::class);
    }
}
