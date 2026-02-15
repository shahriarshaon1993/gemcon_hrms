<?php

namespace App\Models;

use App\Model\Employee;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class UserMOS
 * @package App\Models
 * @version December 6, 2021, 9:27 am UTC
 *
 * @property integer $emp_id
 * @property integer $kra_id
 * @property integer $kpi_id
 * @property integer $mos_id
 * @property integer $year
 */
class UserMOS extends Model
{

    public $table = 'user_m_os';
    



    public $fillable = [
        'emp_id',
        'kra_id',
        'kpi_id',
        'mos_id',
        'year'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'emp_id' => 'integer',
        'kra_id' => 'integer',
        'kpi_id' => 'integer',
        'mos_id' => 'integer',
        'year' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'kra_id' => 'required',
        'kpi_id' => 'required',
        'mos_id' => 'required',
        'year' => 'required'
    ];

    public function employeejoin()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
    public function krajoin()
    {
        return $this->belongsTo(KRA::class, 'kra_id');
    }
    public function kpijoin()
    {
        return $this->belongsTo(KPI::class, 'kpi_id');
    }
    public function mosjoin()
    {
        return $this->belongsTo(MOS::class, 'mos_id');
    }


}
