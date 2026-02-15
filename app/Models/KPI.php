<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class KPI
 * @package App\Models
 * @version April 19, 2021, 5:54 pm UTC
 *
 * @property integer $dept_id
 * @property integer $kra_id
 * @property string $kpi_name
 * @property integer $kpi_weight
 */
class KPI extends Model
{
    use SoftDeletes;

    

    public $table = 'k_p_i_s';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'dept_id',
        'kra_id',
        'kpi_name',
        'year',
        'kpi_weight',
        'employee_sbu',
        'employee_unit',
        'employee_sub_unit',
        'dept_id',
        'employee_section',
        'employee_sub_section',
        'employee_work_location'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'dept_id' => 'integer',
        'kra_id' => 'integer',
        'kpi_name' => 'string',
        'kpi_weight' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [ 
        'kpi_name' => 'required',
        'kpi_weight' => 'required'
    ];
    
    public function krajoin()
    {
        return $this->belongsTo(KRA::class, 'kra_id');
    }
    public function  mosnumber(){
        return $this->belongsTo(MOS::class, 'id' , 'kpi_id')->count();
    }
}
