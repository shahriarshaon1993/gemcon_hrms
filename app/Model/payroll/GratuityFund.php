<?php
namespace App\Model\payroll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class GratuityFund extends Model
{
    protected $table = 'gratuity_funds';
    protected $guarded = array('id','created_at','updated_at');
    public function scopeValid($query)
	{
	   return $query->where('gratuity_funds.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('gratuity_funds.project_id', $project_id);
    }   
}