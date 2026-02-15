<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class CircularDescription extends Model
{
    protected $table = 'circular_descriptions';

    protected $guarded = array('id');

    public function scopeValid($query)
    {
        return $query->where('circular_descriptions.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('circular_descriptions.project_id', $project_id);
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }
}
