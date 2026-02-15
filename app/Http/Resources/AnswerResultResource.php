<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResultResource extends JsonResource
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
            'id' => $this->id,
            'useranswer_id' => $this->useranswer_id,
            'question_id' => $this->question_id,
            'answer_id' => $this->answer_id,
            'improve' => $this->improve,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
