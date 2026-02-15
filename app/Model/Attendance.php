<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $guarded = array('id', 'created_at', 'updated_at');

    protected $appends = ['totalotentry', 'totalotauto', 'totalot'];

    protected $casts = [
        'pdate' => 'date',
    ];

    public function getalldata()
    {
        return $this->hasMany('App\Model\Attendance', 'pdate', 'pdate')
            ->with('joinemployee');
    }
    public function joinemployee()
    {
        return $this->belongsTo('App\Model\Employee', 'employee_id');
    }

    public function scopeValid($query)
    {
        return $query->where('attendance.valid', 1);
    }
    public function getTotalotentryAttribute()
    {
        return $this->getalldata()->where('pdate', $this->pdate)->where('ot_entry', '!=', NULL)->sum('ot_entry');
    }
    public function getTotalotautoAttribute()
    {
        return $this->getalldata()->where('pdate', $this->pdate)->where('ot_entry', '!=', NULL)->sum('ot_time');
    }
    public function getTotalotAttribute()
    {
        return $this->getalldata()->where('pdate', $this->pdate)->where('ot_entry', '!=', NULL)->count('id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
