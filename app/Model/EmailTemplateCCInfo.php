<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class EmailTemplateCCInfo extends Model
{
    protected $table = 'email_templates_cc_info';

    protected $guarded = array('id','created_at','updated_at');

    public function scopeValid($query)
	{
			return $query->where('email_templates_cc_info.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('admin')->user()->project_id;
        return $query->where('email_templates_cc_info.project_id', $project_id);
    }   
}
