<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\KpiResource;
use App\Models\KPI;
class KraTreeResource extends JsonResource
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
            "dept_id" => $this->dept_id , 
            "year" => $this->year , 
            "kra_weight" => $this->kra_weight , 
            "kpiandmosnumber" => $this->kpiandmosnumber() , 
            "kpijoin"  =>  KpiResource::collection( KPI::where('kra_id',  $this->id)->get()), 
            "created_at" => $this->created_at , 
            "updated_at" => $this->updated_at  
        ];
    }
}
