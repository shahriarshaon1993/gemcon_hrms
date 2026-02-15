<?php

namespace App\Repositories;

use App\Models\DepartmentSetting;
use App\Repositories\BaseRepository;

/**
 * Class DepartmentSettingRepository
 * @package App\Repositories
 * @version July 6, 2021, 10:55 am UTC
*/

class DepartmentSettingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'jan',
        'feb',
        'mar',
        'apr',
        'may',
        'jun',
        'jul',
        'aug',
        'sep',
        'oct',
        'nov',
        'dec',
        'trype',
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
        return DepartmentSetting::class;
    }
}
