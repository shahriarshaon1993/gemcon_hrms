<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DepartmentSettingResource ;
use App\Http\Resources\MonthlyDateRangesResource ;
class DepartmentResource extends JsonResource
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
            "id" => $this->id, 
            "name" => $this->department_name, 
            "status" => $this->department_status, 
            "monthly_date_range" => New MonthlyDateRangesResource($this->monthly_date_ranges),
            "setting" => New DepartmentSettingResource($this->setting ),
            "created_at" => $this->created_at, 
            "updated_at" => $this->updated_at, 
            "deleted_at" => $this->deleted_at,  
        ];
    }
}
