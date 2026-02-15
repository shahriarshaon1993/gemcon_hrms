<?php

namespace App\Repositories;

use App\Models\MosFeadback;
use App\Repositories\BaseRepository;

/**
 * Class MosFeadbackRepository
 * @package App\Repositories
 * @version June 28, 2021, 3:18 am UTC
*/

class MosFeadbackRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'mos_id',
        'user_id',
        'msg',
        'month',
        'status'
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
        return MosFeadback::class;
    }
}
