<?php

namespace App\Repositories;

use App\Models\MosDataUser;
use App\Repositories\BaseRepository;

/**
 * Class MosDataUserRepository
 * @package App\Repositories
 * @version May 18, 2021, 8:40 am UTC
*/

class MosDataUserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'mos_id',
        'type',
        'january',
        'february',
        'march',
        'april',
        'may',
        'june',
        'july',
        'august',
        'september',
        'october',
        'november',
        'december',
        'dept_id'
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
        return MosDataUser::class;
    }
}
