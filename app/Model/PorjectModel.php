<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PorjectModel extends Model
{
    protected $table = 'project_info';

    protected $guarded = array('id','created_at','updated_at');
    public function scopeValid($query)
	{
			return $query->where('project_info.valid', 1);
	}

}