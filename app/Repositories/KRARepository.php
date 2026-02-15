<?php

namespace App\Repositories;

use App\Models\KRA;
use App\Repositories\BaseRepository;

/**
 * Class KRARepository
 * @package App\Repositories
 * @version April 19, 2021, 5:36 pm UTC
*/

class KRARepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'kra_name',
        'dept_id',
        'year',
        'kra_weight'
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
        return KRA::class;
    }
}
