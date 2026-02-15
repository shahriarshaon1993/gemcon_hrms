<?php
namespace App\Model\payroll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class DeductionOptionTransaction extends Model
{
    protected $table = 'deduction_option_transaction';
    protected $guarded = array('id','created_at','updated_at');
    public function scopeValid($query)
	{
	   return $query->where('deduction_option_transaction.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('deduction_option_transaction.project_id', $project_id);
    }   
}