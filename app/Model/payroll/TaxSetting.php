<?php
namespace App\Model\payroll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class TaxSetting extends Model
{
   protected $table = 'tax_settings';

    protected $guarded = array('id','created_at','updated_at');

    public function scopeValid($query)
	{
			return $query->where('tax_settings.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('tax_settings.project_id', $project_id);
    }   
}