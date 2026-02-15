<?php

namespace App\Repositories;

use App\Models\DepartmentAssign;
use App\Repositories\BaseRepository;

/**
 * Class DepartmentAssignRepository
 * @package App\Repositories
 * @version June 28, 2021, 7:39 pm UTC
*/

class DepartmentAssignRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'dept_id',
        'user_id'
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
        return DepartmentAssign::class;
    }
}
