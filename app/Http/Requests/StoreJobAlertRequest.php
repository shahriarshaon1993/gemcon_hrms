<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobAlertRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|max:255|unique:job_alerts,email',
            'department_id' => 'nullable|exists:departments,id',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'You are already subscribed to job alerts.',
        ];
    }
}
