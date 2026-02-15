<?php

namespace App\Repositories;

use App\Models\UserAnswer;
use App\Repositories\BaseRepository;

/**
 * Class UserAnswerRepository
 * @package App\Repositories
 * @version November 27, 2021, 8:29 am UTC
*/

class UserAnswerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'assess_by'
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
        return UserAnswer::class;
    }
}
