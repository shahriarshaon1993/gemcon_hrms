<?php

namespace App\Http\Resources;

use App\Models\AnswerResult;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $answerResult = AnswerResult::where('useranswer_id', $this->id)->join('answers', 'answers.id', '=', 'answer_results.question_id');
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'assess_by' => $this->assess_by,
            'user_data' => $this->userjoin,
            'assess_by_data' => $this->assessbyjoin,
            'totalnumber' => $answerResult->sum('answers.mark'),
            'avgnumber' => $answerResult->avg('answers.mark'),
            'countnumber' => $answerResult->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
