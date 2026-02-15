<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;

class JobCircular extends Model
{
    protected $table = 'job_circulars';

    protected $guarded = array('id','created_at','updated_at');

    public function scopeValid($query)
	{
			return $query->where('job_circulars.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('job_circulars.project_id', $project_id);
    }
}
