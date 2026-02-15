<?php
namespace App\Model\payroll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class LoanTransaction extends Model
{
    protected $table = 'loan_adv_transactions';
    protected $guarded = array('id','created_at','updated_at');
    public function scopeValid($query)
	{
	   return $query->where('loan_adv_transactions.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('loan_adv_transactions.project_id', $project_id);
    }   
}