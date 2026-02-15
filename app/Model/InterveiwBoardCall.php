<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;

class InterveiwBoardCall extends Model
{
    protected $table = 'interview_board_calls';

    protected $guarded = array('id','created_at','updated_at');

    public function scopeValid($query)
	{
			return $query->where('interview_board_calls.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('interview_board_calls.project_id', $project_id);
    }
}
