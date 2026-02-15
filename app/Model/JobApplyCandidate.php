<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class JobApplyCandidate extends Model
{
   protected $table = 'job_apply_candidates';

    protected $guarded = array('id','created_at','updated_at');

    public function scopeValid($query)
	{
			return $query->where('job_apply_candidates.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('job_apply_candidates.project_id', $project_id);
    }

    public function circular(): BelongsTo
    {
        return $this->belongsTo(JobCircular::class,'jac_job_circular_id','id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Designation::class, 'jac_job_position', 'id');
    }

    public function company()
    {
        return $this->belongsTo(CompanySbu::class, 'jac_company_name', 'id');
    }

    public function university()
    {
        return $this->belongsTo(University::class,'jac_universitgy_name','id');
    }
}
