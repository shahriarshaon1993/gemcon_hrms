<?php
namespace App\Model;
use Auth;
use Illuminate\Database\Eloquent\Model;

class BranchModel extends Model
{
    protected $table = 'branch_info';

    protected $guarded = array('id','created_at','updated_at');

    public function scopeValid($query)
	{
			return $query->where('branch_info.valid', 1);
    }

    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('branch_info.company_id', $project_id);
    }
    public function branch_id(){

        
        $project_id=Auth::guard('user')->user()->project_id;
        $branch_id=Auth::guard('user')->user()->branch_id;

        // return $branch_id;
        if($project_id == $branch_id){
            $branche_idAll=BranchModel::valid()->where('company_id',$project_id)->get();
            $branche_ids=collect(collect($branche_idAll)->pluck('id')->unique()->values('branch_id')->all())->toArray();
         }else{
            $branche_idAll=BranchModel::valid()->where('company_id',$project_id)->where('id',$branch_id)->get();
            $branche_ids=collect(collect($branche_idAll)->pluck('id')->unique()->values('branch_id')->all())->toArray();
       
        }
        return $branche_ids;

    }
}