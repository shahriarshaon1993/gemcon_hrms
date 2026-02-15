<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class MosData
 * @package App\Models
 * @version May 18, 2021, 8:40 am UTC
 *
 * @property integer $mos_id
 * @property integer $type
 * @property number $january
 * @property number $february
 * @property number $march
 * @property number $april
 * @property number $may
 * @property number $june
 * @property number $july
 * @property number $august
 * @property number $september
 * @property number $october
 * @property number $november
 * @property number $december
 * @property integer $dept_id
 */
class MosData extends Model
{
    use SoftDeletes;

    

    public $table = 'mos_datas';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'mos_id',
        'type',
        'january',
        'february',
        'march',
        'april',
        'may',
        'june',
        'july',
        'year',
        'august',
        'september',
        'october',
        'november',
        'december',
        'total',
        'dept_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'mos_id' => 'integer',
        'type' => 'string',
        'january' => 'float',
        'february' => 'float',
        'march' => 'float',
        'april' => 'float',
        'may' => 'float',
        'june' => 'float',
        'july' => 'float',
        'august' => 'float',
        'september' => 'float',
        'october' => 'float',
        'november' => 'float',
        'december' => 'float',
        'dept_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'mos_id' => 'required',
        'type' => 'required',
        'december' => 'dept_id integer:unsigned:foreign,departments,id',
        'dept_id' => 'required'
    ];

    
}
