<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class DepartmentSetting
 * @package App\Models
 * @version July 6, 2021, 10:55 am UTC
 *
 * @property string $jan
 * @property string $feb
 * @property string $mar
 * @property string $apr
 * @property string $may
 * @property string $jun
 * @property string $jul
 * @property string $aug
 * @property string $sep
 * @property string $oct
 * @property string $nov
 * @property string $dec
 * @property string $trype
 * @property integer $dept_id
 */
class DepartmentSetting extends Model
{
    use SoftDeletes;

    

    public $table = 'department_settings';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'jan',
        'feb',
        'mar',
        'apr',
        'may',
        'jun',
        'jul',
        'aug',
        'sep',
        'oct',
        'nov',
        'dec',
        'type',
        'dept_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'jan' => 'string',
        'feb' => 'string',
        'mar' => 'string',
        'apr' => 'string',
        'may' => 'string',
        'jun' => 'string',
        'jul' => 'string',
        'aug' => 'string',
        'sep' => 'string',
        'oct' => 'string',
        'nov' => 'string',
        'dec' => 'string',
        'type' => 'string',
        'dept_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
