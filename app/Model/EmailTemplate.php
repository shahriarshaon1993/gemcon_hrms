<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class EmailTemplate extends Model
{
    protected $table = 'email_templates';

    protected $guarded = array('id','created_at','updated_at');

    public function scopeValid($query)
	{
			return $query->where('email_templates.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('admin')->user()->project_id;
        return $query->where('email_templates.project_id', $project_id);
    }   
}
