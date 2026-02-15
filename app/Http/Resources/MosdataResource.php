<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MosdataResource extends JsonResource
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
            "id" =>  $this->id,
            "mos_id" =>  $this->mos_id,
            "type" =>  $this->type,
            "january" =>  $this->january,
            "february" =>  $this->february,
            "march" =>  $this->march,
            "april" =>  $this->april,
            "may" =>  $this->may,
            "june" =>  $this->june,
            "july" =>  $this->july,
            "august" =>  $this->august,
            "september" =>  $this->september,
            "october" =>  $this->october,
            "november" =>  $this->november,
            "december" =>  $this->december,
            "total" => ( $this->january + $this->february + $this->march + $this->april + $this->may + $this->june + $this->july + $this->august + $this->september + $this->october + $this->november + $this->december ) ,
            "sum_total" => ( $this->january + $this->february + $this->march + $this->april + $this->may + $this->june + $this->july + $this->august + $this->september + $this->october + $this->november + $this->december ) ,
            "dept_id" =>  $this->dept_id,
            "created_at" =>  $this->created_at,
            "updated_at" =>  $this->updated_at 
        ];
    }
}
