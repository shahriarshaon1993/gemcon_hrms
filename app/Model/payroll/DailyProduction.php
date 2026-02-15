<?php

namespace App\Model\payroll;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class DailyProduction extends Model
{
    protected $table = 'daily_production_entries';
    protected $appends = ['totalqty', 'totalotqty', 'totalamount', 'totalemp'];

    protected $guarded = array('id', 'created_at', 'updated_at');

    public function scopeValid($query)
    {
        return $query->where('daily_production_entries.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('daily_production_entries.project_id', $project_id);
    }



    public function joinemployee()
    {
        return $this->belongsTo('App\Model\Employee', 'employee_id');
    }

    public function joinsbu()
    {
        return $this->belongsTo('App\Model\CompanySbu', 'sbu_id');
    }

    public function joinshift()
    {
        return $this->belongsTo('App\Model\OfficeTimeSetup', 'shift_id');
    }

    public function joinproduct()
    {
        return $this->belongsTo('App\Model\payroll\ProductSetting', 'product_id');
    }

    public function joinbundle()
    {
        return $this->belongsTo('App\Model\payroll\BundleSetting', 'bundle_id');
    }

    public function joingrade()
    {
        return $this->belongsTo('App\Model\payroll\GradeSetting', 'grade_id');
    }

    public function joinline()
    {
        return $this->belongsTo('App\Model\payroll\LineSetting', 'line_id');
    }

    public function joinmachine()
    {
        return $this->belongsTo('App\Model\payroll\MachineSetting', 'machine_id');
    }
    // public function thismodel()
    // {
    //     return $this->belongsTo('App\Model\payroll\DailyProduction', 'production_date', '');
    //     return DailyProduction::where('production_date', $this->production_date);
    // }
    // public function totalqty()
    // {
    //     return $this->thismodel->sum('product_quantity');
    // }
    public function getalldata()
    {
        return $this->hasMany('App\Model\payroll\DailyProduction', 'production_date', 'production_date')
            ->with('joinemployee', 'joinsbu', 'joinshift', 'joinproduct', 'joinbundle', 'joingrade', 'joinline', 'joinmachine');
    }
    public function getTotalotqtyAttribute()
    {
        return $this->all()->where('production_date', $this->production_date)->sum('product_qt_quantity');
    }
    public function getTotalqtyAttribute()
    {
        return $this->all()->where('production_date', $this->production_date)->sum('product_quantity');
    }
    public function getTotalamountAttribute()
    {
        return $this->all()->where('production_date', $this->production_date)->sum('amount');
    }
    public function getTotalempAttribute()
    {
        return $this->all()->where('production_date', $this->production_date)->count('id');
    }
}
