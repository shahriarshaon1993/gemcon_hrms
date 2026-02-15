<?php

namespace App\Models;

use Eloquent as Model;
use App\Models\MosData;
use App\Models\MOS;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;

/**
 * Class Department
 * @package App\Models
 * @version April 19, 2021, 11:51 am UTC
 *
 * @property string $name
 * @property integer $status
 */
class Department extends Model
{
    use SoftDeletes;



    public $table = 'departments';


    protected $dates = ['deleted_at'];



    public $fillable = [


        'department_name',
        'department_status',
        'department_code',
        'department_head',
        'priority',
        'project_id',
        'branch_id',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
        'valid',


    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'status' => 'integer',
        'is_factory' => 'integer',
        'is_tour' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'status' => 'required'
    ];
    public function setting()
    {
        return $this->belongsTo(DepartmentSetting::class, 'id', 'dept_id');
    }
    public function monthly_date_ranges()
    {
        return $this->belongsTo(MonthlyDateRange::class, 'id', 'dept_id');
    }
    public function target()
    {
        // $current_month =  strtolower(date("F")) ;
        $target_biulder = MOS::select(DB::Raw('SUM(january) as january, SUM(february) as february
        , SUM(march) as march, SUM(april) as april, SUM(may) as may, SUM(june) as june, SUM(july) as july
        , SUM(august) as august, SUM(september) as september, SUM(october) as october, SUM(november) as november
        , SUM(december) as december'))
            ->join('mos_datas', 'mos_datas.mos_id', 'm_o_s.id');
        $target_biulder->where('m_o_s.dept_id', $this->id);
        $target = $target_biulder->where('mos_datas.type', 'target')->first();
        return   $target;
        // return  $target->$current_month ? $target->$current_month : 0 ;

    }
    public function achievement()
    {
        //$current_month =  strtolower(date("F")) ;
        $target_biulder = MOS::select(DB::Raw('SUM(january) as january, SUM(february) as february
        , SUM(march) as march, SUM(april) as april, SUM(may) as may, SUM(june) as june, SUM(july) as july
        , SUM(august) as august, SUM(september) as september, SUM(october) as october, SUM(november) as november
        , SUM(december) as december'))
            ->join('mos_datas', 'mos_datas.mos_id', 'm_o_s.id');
        $target_biulder->where('m_o_s.dept_id', $this->id);
        $target = $target_biulder->where('mos_datas.type', 'achievement')->first();
        return $target;
        // return   $target->$current_month ? $target->$current_month : 0  ;
    }
}
