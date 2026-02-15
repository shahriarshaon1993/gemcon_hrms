<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class MosFeadback
 * @package App\Models
 * @version June 28, 2021, 3:18 am UTC
 *
 * @property int $mos_id
 * @property int $user_id
 * @property string $msg
 * @property string $month
 * @property int $status
 */
class MosFeadback extends Model
{
    use SoftDeletes;

    

    public $table = 'mos_feadbacks';
     
    protected $dates = ['deleted_at'];
  
    public $fillable = [
        'mos_id',
        'user_id',
        'msg',
        'dept_id',
        'date',
        'fmonth',
        'month',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'msg' => 'string',
        'month' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
 
    public static $rules = [
        'mos_id' => 'required'
    ];

    public function feedbackUser()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
