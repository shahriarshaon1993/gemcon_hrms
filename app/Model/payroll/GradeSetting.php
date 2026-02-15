<?php
namespace App\Model\payroll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class GradeSetting extends Model
{
    protected $table = 'grade_production_settings';

    protected $guarded = array('id','created_at','updated_at');

    public function scopeValid($query)
	{
		return $query->where('grade_production_settings.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('grade_production_settings.project_id', $project_id);
    }   
}
