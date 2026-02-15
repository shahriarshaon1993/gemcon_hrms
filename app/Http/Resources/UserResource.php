<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "name" => $this->name , 
            "email" => $this->email , 
            "employee_id" => $this->employee_id , 
            "designation" => $this->designation , 
            "status" => $this->status , 
            "phone" => $this->phone , 
            "dept_id" => $this->dept_id ,
            "rolejoin" => $this->rolejoin ,  
            "deptjoin" => $this->deptjoin ,  
            "role_id" => $this->role_id , 
            "is_factory" => $this->is_factory , 
            "wing_id" => $this->wing_id , 
            "email_verified_at" => $this->email_verified_at ,  
            "remember_token" => $this->remember_token ,  
            "wingjoin" => $this->wingjoin ,  
             
        ];
    }
}
