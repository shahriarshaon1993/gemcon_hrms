<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "created_by" => $this->created_by ,
            "updated_by" => $this->updated_by ,
            "created_at" => $this->created_at ,
            "updated_at" => $this->updated_at , 
            "plant" => $this->plant , 
            "product_group" => $this->product_group,
            "material_code" => $this->material_code ,
            "description" => $this->description ,
            "material_group_id" => $this->material_group_id , 
            "material_type" => $this->material_type ,
            "base_unit_of_measure" => $this->base_unit_of_measure ,
            "materialgroupjoin" => $this->materialgroupjoin(),   
            "plantjoin" => $this->plantjoin()   
        ];
    }
}
