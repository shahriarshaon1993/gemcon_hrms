<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Talent extends Model
{
    protected $table = 'talents';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'department_id',
        'experience_level',
        'address',
        'cv',
        'description',
        'is_agree',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
