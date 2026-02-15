<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MosdataResource;
class MosTreeResource extends JsonResource
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
            "id" => $this->id ,   
            "dept_id" => $this->dept_id, 
            "kra_id" => $this->kra_id, 
            "kra_count" =>$this->count_kra,
            "krajoin" =>$this->krajoin, 
            "kpi_count" =>$this->count_kpi, 
            "kpijoin" =>$this->kpijoin, 
            "kpi_id" => $this->kpi_id, 
            "mos_name" => $this->mos_name, 
            "mos_calculation" => $this->mos_calculation, 
            "weightage" => $this->weightage, 
            "isvalorper" => $this->isvalorper,
            "mosachievementjoin" => New MosdataResource($this->mosachievementjoin),
            "mostargetjoin" => New MosdataResource($this->mostargetjoin),
        ];
    }
}
