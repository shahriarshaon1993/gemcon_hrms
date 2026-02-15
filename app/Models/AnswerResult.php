<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class AnswerResult
 * @package App\Models
 * @version November 27, 2021, 8:42 am UTC
 *
 * @property integer $useranswer_id
 * @property integer $question_id
 * @property integer $answer_id
 * @property string $improve
 */
class AnswerResult extends Model
{

    public $table = 'answer_results';
    



    public $fillable = [
        'useranswer_id',
        'question_id',
        'answer_id',
        'improve'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'useranswer_id' => 'integer',
        'question_id' => 'integer',
        'answer_id' => 'integer',
        'improve' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'useranswer_id' => 'required',
        'question_id' => 'required',
        'answer_id' => 'required'
    ];

    
}
