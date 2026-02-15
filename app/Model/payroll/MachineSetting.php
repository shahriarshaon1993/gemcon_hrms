<?php
namespace App\Model\payroll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class MachineSetting extends Model
{
    protected $table = 'machine_settings';

    protected $guarded = array('id','created_at','updated_at');

    public function scopeValid($query)
	{
		return $query->where('machine_settings.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('machine_settings.project_id', $project_id);
    }   
}
