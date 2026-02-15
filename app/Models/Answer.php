<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Answer
 * @package App\Models
 * @version November 18, 2021, 4:32 am UTC
 *
 * @property integer $question_id
 * @property string $vAnswer
 * @property integer $mark
 * @property integer $order_list
 */
class Answer extends Model
{

    public $table = 'answers';
    



    public $fillable = [
        'question_id',
        'vAnswer',
        'mark',
        'order_list'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'question_id' => 'integer',
        'vAnswer' => 'string',
        'mark' => 'integer',
        'order_list' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'question_id' => 'required'
    ];

    
}
