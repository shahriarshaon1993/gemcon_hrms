<?php
namespace App\Model\payroll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class DeductionType extends Model
{
    protected $table = 'deduction_type';
    protected $guarded = array('id','created_at','updated_at');
    public function scopeValid($query)
    {
       return $query->where('deduction_type.valid', 1);
    }
  
}