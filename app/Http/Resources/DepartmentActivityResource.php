<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $target  =  $this->target() ;
        $achievement =  $this->achievement() ; 
       // $remaining  = $target -  $achievement ;
        return [
            "id" => $this->id ,  
            "name" => $this->name ,  
            "status" => $this->status ,   
            "target" =>$target  ,     
            "achievement" => $achievement , 
            //"remaining" => number_format($remaining,2) ,
            // "target" => number_format($target ,2)  ,     
            // "achievement" => number_format($achievement,2) , 
            // "remaining" => number_format($remaining,2) ,
            "created_by" => $this->created_by ,
            "updated_by" => $this->updated_by ,
            "created_at" => $this->created_at ,
            "updated_at" => $this->updated_at 
        ];
    }
}
