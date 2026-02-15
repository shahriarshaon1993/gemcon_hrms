<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            // 'employee_sbu' => $this->employee_sbu,
            // 'employee_unit' => $this->employee_unit,
            // 'employee_sub_unit' => $this->employee_sub_unit,
            // 'dept_id' => $this->dept_id,
            // 'employee_section' => $this->employee_section,
            // 'employee_sub_section' => $this->employee_sub_section,
            // 'employee_work_location' => $this->employee_work_location,
            'mos_id' => $this->mos_id,
            'mosdata' => $this->mosjoin,
            'year' => $this->year,
            'vQuestion' => $this->vQuestion,
            'contant' => $this->contant,
            // 'sbujoin' => $this->sbujoin,
            // 'unitjoin' => $this->unitjoin,
            // 'subunitjoin' => $this->subunitjoin,
            // 'sectionjoin' => $this->sectionjoin,
            // 'subsectionjoin' => $this->subsectionjoin,
            // 'departmentjoin' => $this->departmentjoin,
            'answersjoin' => $this->answersjoin,
            'value' => '',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
