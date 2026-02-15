<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTalentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|max:255|unique:talents,email',
            'phone'            => 'required|string|max:20',
            'department_id'    => 'nullable|exists:departments,id',
            'experience_level' => 'nullable|string|max:50',
            'address'          => 'nullable|string|max:255',
            'cv'               => 'required|file|mimes:pdf,doc,docx|max:2048',
            'description'      => 'nullable|string',
            'is_agree'         => 'accepted',
        ];
    }
}
