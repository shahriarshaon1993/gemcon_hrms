<?php

namespace App\Model;
use Auth;

class Vendor extends BaseModel
{
    protected $table = 'inv_vendor';

    protected $guarded = array('id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by', 'valid');

    public static function boot()
    {
        parent::userBoot();
    }

    public function scopeValid($query)
    {
        return $query->where('inv_vendor.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('inv_vendor.project_id', $project_id);
    }
    
}
