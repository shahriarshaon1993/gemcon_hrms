<?php

namespace App\Repositories;

use App\Models\KPI;
use App\Repositories\BaseRepository;

/**
 * Class KPIRepository
 * @package App\Repositories
 * @version April 19, 2021, 5:54 pm UTC
*/

class KPIRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'dept_id',
        'kra_id',
        'kpi_name',
        'kpi_weight'
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
        return KPI::class;
    }
}
