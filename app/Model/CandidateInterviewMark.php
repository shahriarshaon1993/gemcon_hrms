<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CandidateInterviewMark extends Model
{
    protected $table = 'candidate_interview_marks';

    protected $guarded = array('id');
}
