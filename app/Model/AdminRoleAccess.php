<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminRoleAccess extends BaseModel
{
    protected $table = 'admin_role_access';

    protected $guarded = array('id', 'created_at', 'updated_at');

    public static function boot()
    {
        parent::adminBoot();
    }

    public function scopeValid($query)
    {
        return $query->where('admin_role_access.valid', 1);
    }
}
