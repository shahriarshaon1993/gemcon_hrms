<?php

namespace App\Repositories;

use App\Models\MOS;
use App\Repositories\BaseRepository;

/**
 * Class MOSRepository
 * @package App\Repositories
 * @version April 19, 2021, 5:57 pm UTC
*/

class MOSRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'dept_id',
        'kra_id',
        'kpi_id',
        'mos_name'
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
        return MOS::class;
    }
}
