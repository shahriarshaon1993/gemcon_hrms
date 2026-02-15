<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class MonthlyDateRange
 * @package App\Models
 * @version July 11, 2021, 5:07 am UTC
 *
 * @property integer $dept_id
 * @property  $start_date
 * @property string $end_date
 * @property integer $status
 */
class MonthlyDateRange extends Model
{
    use SoftDeletes;


    public $table = 'monthly_date_ranges';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'dept_id',
        'start_date',
        'end_date',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'dept_id' => 'integer',
        'end_date' => 'date',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];
}
