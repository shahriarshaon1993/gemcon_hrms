<?php
namespace App\Model\payroll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class BundleSetting extends Model
{
    protected $table = 'bundle_settings';

    protected $guarded = array('id','created_at','updated_at');

    public function scopeValid($query)
	{
		return $query->where('bundle_settings.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('bundle_settings.project_id', $project_id);
    }   
}
