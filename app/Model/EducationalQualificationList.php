<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class EducationalQualificationList extends Model
{
   protected $table = 'educational_qualification_lists';

    protected $guarded = array('id','created_at','updated_at');

    public function scopeValid($query)
	{
			return $query->where('educational_qualification_lists.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('educational_qualification_lists.project_id', $project_id);
    }   
}