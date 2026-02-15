<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\MOS; 
use App\Http\Resources\MosResource;
class KpiResource extends JsonResource
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
            "kpi_name" => $this->kpi_name , 
            "kpi_weight" => $this->kpi_weight ,
            "dept_id" => $this->dept_id ,
            "kra_id" => $this->kra_id , 
            "kra_id" => $this->kra_id , 
            "mosnumber" => $this->mosnumber ,
            "mosjoin"  =>  MosResource::collection( MOS::where('kpi_id',  $this->id)->get()) 
        ];
    }
}
