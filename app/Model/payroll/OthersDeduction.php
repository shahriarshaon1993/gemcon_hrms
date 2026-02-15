<?php
namespace App\Model\payroll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class OthersDeduction extends Model
{
    protected $table = 'others_deduction';
    protected $guarded = array('id','created_at','updated_at');
    public function scopeValid($query)
    {
       return $query->where('others_deduction.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('others_deduction.project_id', $project_id);
    }   
}