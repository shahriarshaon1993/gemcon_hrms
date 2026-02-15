<?php

namespace App\Models;

use App\Models\KRA;
use App\Models\KPI;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class MOS
 * @package App\Models
 * @version April 19, 2021, 5:57 pm UTC
 *
 * @property integer $dept_id
 * @property integer $kra_id
 * @property integer $kpi_id
 * @property string $mos_name
 */
class MOS extends Model
{
    use SoftDeletes;



    public $table = 'm_o_s';


    protected $dates = ['deleted_at'];

    public $fillable = [
        'dept_id',
        'kra_id',
        'kpi_id',
        'weightage',
        'year',
        'isvalorper',
        'mos_calculation',
        'mos_name',
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
        'kpi_id' => 'integer',
        'mos_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'kpi_id' => 'required',
        'mos_name' => 'required'
    ];

    public function mostargetjoin($request = NULL)
    {

        if (isset($request->year)) {
            return $this->belongsTo(MosData::class, 'id', 'mos_id')->where('type', 'target')->where('year', $request->year);
        } else {
            return $this->belongsTo(MosData::class, 'id', 'mos_id')->where('type', 'target');
        }
    }
    public function mosmodulejoin($request = NULL)
    {

        if (isset($request->year)) {
            return $this->belongsTo(MosData::class, 'id', 'mos_id')->where('type', 'module')->where('year', $request->year);
        } else {
            return $this->belongsTo(MosData::class, 'id', 'mos_id')->where('type', 'module');
        }
    }
    public function mosachievementjoin($request = NULL)
    {
        if (isset($request->year)) {
            return $this->belongsTo(MosData::class, 'id', 'mos_id')->where('type', 'achievement')
                ->where('year', $request->year);
        } else {
            return $this->belongsTo(MosData::class, 'id', 'mos_id')->where('type', 'achievement');
        }
    }

    public function mosuserachievementjoin($request = NULL)
    {
        if (isset($request->year)) {
            return $this->belongsTo(MosDataUser::class, 'id', 'mos_id')
                ->where('year', $request->year);
        } else {
            return $this->belongsTo(MosDataUser::class, 'id', 'mos_id');
        }
    }

    public function feadback()
    {
        $year = date('Y');
        return $this->belongsToMany(MosFeadback::class, 'id', 'mos_id')->where('date', 'LIKE', "%{$year}%");
    }
    public function getCountKraAttribute()
    {
        return MOS::where('kra_id', $this->kra_id)->where('dept_id', $this->dept_id)->count();
    }
    public function getCountKpiAttribute()
    {
        return MOS::where('kpi_id', $this->kpi_id)->where('dept_id', $this->dept_id)->count();
    }
    public function krajoin()
    {
        return $this->belongsTo(KRA::class, 'kra_id');
    }
    public function kpijoin()
    {
        return $this->belongsTo(KPI::class, 'kpi_id');
    }
}
