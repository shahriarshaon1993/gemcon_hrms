<?php
namespace App\Model\payroll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class MobileInternetBill extends Model
{
    protected $table = 'mobile_internet_bills';
    protected $guarded = array('id','created_at','updated_at');
    public function scopeValid($query)
	{
	   return $query->where('mobile_internet_bills.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('mobile_internet_bills.project_id', $project_id);
    }   
}