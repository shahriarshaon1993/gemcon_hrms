<?php

namespace App\Models;

use App\Model\UsersPersonModel;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class UserAnswer
 * @package App\Models
 * @version November 27, 2021, 8:29 am UTC
 *
 * @property integer $user_id
 * @property integer $assess_by
 */
class UserAnswer extends Model
{

    public $table = 'user_answers';




    public $fillable = [
        'user_id',
        'assess_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'assess_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];

    public function userjoin()
    {
        return $this->belongsTo(UsersPersonModel::class, 'user_id');
    }
    public function assessbyjoin()
    {
        return $this->belongsTo(UsersPersonModel::class, 'assess_by');
    }
}
