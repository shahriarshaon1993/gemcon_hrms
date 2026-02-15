<?php

namespace App\Repositories;

use App\Models\UserMOS;
use App\Repositories\BaseRepository;

/**
 * Class UserMOSRepository
 * @package App\Repositories
 * @version December 6, 2021, 9:27 am UTC
*/

class UserMOSRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'emp_id',
        'kra_id',
        'kpi_id',
        'mos_id',
        'year'
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
        return UserMOS::class;
    }
}
