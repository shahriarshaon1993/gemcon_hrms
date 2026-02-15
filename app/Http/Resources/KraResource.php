<?php

namespace App\Http\Resources;
use App\Models\KPI;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\KpiResource;
class KraResource extends JsonResource
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
            "kra_name" => $this->kra_name , 
            "kra_weight" => $this->kra_weight , 
           
            "kpijoin" =>  KpiResource::collection( KPI::where('kra_id',  $this->id)->get()) 
        ];
    }
}
