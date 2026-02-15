<?php

namespace App\Model;

class AdminRole extends BaseModel
{
    protected $table = 'admin_role';

    protected $guarded = array('id', 'created_at', 'updated_at');

    public static function boot()
    {
        parent::adminBoot();
    }

    public function scopeValid($query)
    {
        return $query->where('admin_role.valid', 1);
    }
}
