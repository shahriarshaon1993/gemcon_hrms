<?php

namespace App\Repositories;

use App\Models\AnswerResult;
use App\Repositories\BaseRepository;

/**
 * Class AnswerResultRepository
 * @package App\Repositories
 * @version November 27, 2021, 8:42 am UTC
*/

class AnswerResultRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'useranswer_id',
        'question_id',
        'answer_id',
        'improve'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AnswerResult::class;
    }
}
