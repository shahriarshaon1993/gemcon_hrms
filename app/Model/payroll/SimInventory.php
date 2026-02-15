<?php
namespace App\Model\payroll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class SimInventory extends Model
{
    protected $table = 'sim_inventory';
    protected $guarded = array('id','created_at','updated_at');
    public function scopeValid($query)
	{
	   return $query->where('sim_inventory.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('sim_inventory.project_id', $project_id);
    }   
}