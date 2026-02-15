<?php

namespace App\Model;
use Auth;

class ModuleModel extends BaseModel
{
	protected $table = 'module_data';

	protected $guarded = array('id', 'created_by', 'created_at','updated_by','updated_at','deleted_by','deleted_at','valid');

	public static function boot()
	{
			parent::userBoot();
	}

	public function scopeValid($query)
	{
			return $query->where('module_data.valid', 1);
	}
	public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('module_data.project_id', $project_id);
    }
}
