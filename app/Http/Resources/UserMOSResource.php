<?php

namespace App\Http\Resources;

use App\Models\KPI;
use App\Models\KRA;
use App\Models\MOS;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMOSResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'emp_id' => $this->emp_id,
            'kra_id' => $this->kra_id,
            'kpi_id' => $this->kpi_id,
            'mos_id' => $this->mos_id,
            'year' => $this->year,
            "employeedata" => $this->employeejoin,
            "krajoin" =>  $this->krajoin,
            "kpijoin" =>  $this->kpijoin,
            "mosjoin" =>  $this->mosjoin,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
