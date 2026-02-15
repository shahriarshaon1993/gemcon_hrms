<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class DepartmentAssign
 * @package App\Models
 * @version June 28, 2021, 7:39 pm UTC
 *
 * @property integer $dept_id
 * @property integer $user_id
 */
class DepartmentAssign extends Model
{
    use SoftDeletes;

    

    public $table = 'department_assigns';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'dept_id',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'dept_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function userjoin()
    {
        return $this->belongsTo(User::class,'id' , 'user_id');
    }
    public function deptjoin()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }
}
