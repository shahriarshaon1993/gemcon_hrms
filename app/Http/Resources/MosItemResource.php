<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MosdataResource;
use App\Http\Resources\MosFeadbackResource;
class MosItemResource extends JsonResource
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
            "mos_name" => $this->mos_name,
            "weightage" => $this->weightage,
            "isvalorper" => $this->isvalorper,
           // "feadback" =>  MosFeadbackResource::collection($this->feadback) ,
            "feadback" => $this->feadback(),
            "mos_calculation" => $this->mos_calculation,
            "mostargetjoin" => New MosdataResource($this->mostargetjoin),
            "mosmodulejoin" => New MosdataResource($this->mosmodulejoin),
            "mosachievementjoin" => New MosdataResource($this->mosachievementjoin),
        ];
    }
}
