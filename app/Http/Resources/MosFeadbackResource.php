<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MosFeadbackResource extends JsonResource
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
            "mos_id" => $this->mos_id, 
            "user_id" => $this->user_id, 
            "msg" => $this->msg, 
            "month" => $this->month, 
            "status" => $this->status, 
            "created_at" => $this->created_at, 
            "updated_at" => $this->updated_at, 
            "deleted_at" => $this->deleted_at
        ];
    }
}
