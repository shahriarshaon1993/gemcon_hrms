<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MosdataResource;
class MosResource extends JsonResource
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
            "kpi_id" => $this->kpi_id ,
            "weightage" => $this->weightage ,
            "mos_name" => $this->mos_name ,
            "mosachievementjoin" => New MosdataResource($this->mosachievementjoin),
            "mostargetjoin" => New MosdataResource($this->mostargetjoin),
        ];
    }
}
