<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class DashboardSettingModel extends Model
{
    protected $table = 'dashboard_widget';

    protected $guarded = array('id','created_at','updated_at');

    public function scopeValid($query)
    {
            return $query->where('dashboard_widget.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('dashboard_widget.project_id', $project_id);
    }   
}

