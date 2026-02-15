<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MonthlyDateRangesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $currentDate = date('Y-m-d');
        $currentDate = date('Y-m-d', strtotime($currentDate));
        //echo $paymentDate; // echos today! 
        $start_date = date('Y-m-d', strtotime($this->start_date ? $this->start_date : ''));
        $end_date = date('Y-m-d', strtotime($this->end_date ? $this->end_date : ''));
        // return $this->sendResponse($end_date, 'Monthly Report saved successfully');  
        $curent_time =  false;
        if (($currentDate >= $start_date) && ($currentDate <= $end_date) && ($this->status == 1)) {
            $curent_time  =  true;
        }

        return [
            "id" => $this->id,
            "start_date"  => $this->start_date,
            "status"  => $curent_time,
            "curent_time_status"  => $curent_time,
            "end_date"  => $this->end_date,
            "dept_id" => $this->dept_id,
        ];
    }
}
