<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\MOS; 
use App\Http\Resources\MosItemResource;
class KpiItemResource extends JsonResource
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
            "krajoin" => $this->krajoin,
            "kpi_name" => $this->kpi_name , 
            "kpi_weight" => $this->kpi_weight ,
            "kra_id" => $this->kra_id , 
            "dept_id" => $this->dept_id , 
            "mosjoin"  =>  MosItemResource::collection( MOS::where('kpi_id',  $this->id)->get()) 
        ];
    }
}
