<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentSettingResource extends JsonResource
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
            "id" =>$this->id  , 
            "jan" =>$this->jan == 1 ? TRUE : FALSE , 
            "feb" =>$this->feb == 1 ? TRUE : FALSE , 
            "mar" =>$this->mar == 1 ? TRUE : FALSE , 
            "apr" =>$this->apr == 1 ? TRUE : FALSE , 
            "may" =>$this->may == 1 ? TRUE : FALSE , 
            "jun" =>$this->jun == 1 ? TRUE : FALSE , 
            "jul" =>$this->jul == 1 ? TRUE : FALSE , 
            "aug" =>$this->aug == 1 ? TRUE : FALSE , 
            "sep" =>$this->sep == 1 ? TRUE : FALSE , 
            "oct" =>$this->oct == 1 ? TRUE : FALSE , 
            "nov" =>$this->nov == 1 ? TRUE : FALSE , 
            "dec" =>$this->dec == 1 ? TRUE : FALSE , 
            "type" =>$this->type  , 
            "dept_id" =>$this->dept_id  ,
        ];
    }
}
