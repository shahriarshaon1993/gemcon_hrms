<?php

namespace App\Models;
use App\Model\CompanySbu;
use App\Model\UnitModel;
use App\Model\SubUnit;
use App\Model\Section;
use App\Model\SubSection;
use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Question
 * @package App\Models
 * @version November 17, 2021, 11:51 am UTC
 *
 * @property integer $employee_sbu
 * @property integer $employee_unit
 * @property integer $employee_sub_unit
 * @property integer $dept_id
 * @property integer $employee_section
 * @property integer $employee_sub_section
 * @property integer $employee_work_location
 * @property integer $year
 * @property string $vQuestion
 * @property string $contant
 */
class Question extends Model
{

    public $table = 'questions';
    



    public $fillable = [
        // 'employee_sbu',
        // 'employee_unit',
        // 'employee_sub_unit',
        // 'dept_id',
        // 'employee_section',
        // 'employee_sub_section',
        // 'employee_work_location',
        'mos_id',
        'year',
        'vQuestion',
        'contant'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'employee_sbu' => 'integer',
        // 'employee_unit' => 'integer',
        // 'employee_sub_unit' => 'integer',
        // 'dept_id' => 'integer',
        // 'employee_section' => 'integer',
        // 'employee_sub_section' => 'integer',
        // 'employee_work_location' => 'integer',
        'mos_id' => 'integer',
        'year' => 'integer',
        'vQuestion' => 'string',
        'contant' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function mosjoin()
    {
        return $this->belongsTo(MOS::class, 'mos_id');
    }
    // public function sbujoin()
    // {
    //     return $this->belongsTo(CompanySbu::class, 'employee_sbu');
    // }
    // public function unitjoin()
    // {
    //     return $this->belongsTo(UnitModel::class, 'employee_unit');
    // }
    // public function subunitjoin()
    // {
    //     return $this->belongsTo(SubUnit::class, 'employee_sub_unit');
    // }
    // public function sectionjoin()
    // {
    //     return $this->belongsTo(Section::class, 'employee_section');
    // }
    // public function subsectionjoin()
    // {
    //     return $this->belongsTo(SubSection::class, 'employee_sub_section');
    // }
    // public function departmentjoin()
    // {
    //     return $this->belongsTo(Department::class, 'dept_id');
    // }
    public function answersjoin()
    {
        return $this->hasMany(Answer::class,  'question_id');
    }
    
}
