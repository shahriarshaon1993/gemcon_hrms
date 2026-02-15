<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SapFiles
 * @package App\Models
 * @version July 1, 2021, 1:06 pm UTC
 *
 * @property string $file_name
 * @property string $comp_code
 * @property string $note
 * @property string $date
 */
class SapFiles extends Model
{
    use SoftDeletes;

    

    public $table = 'sap_files';
    

    protected $dates = ['deleted_at'];
 
    public $fillable = [
        'file_name',
        'file_name_url',
        'comp_code',
        'note',
        'date',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'file_name' => 'string',
        'comp_code' => 'string',
        'note' => 'string',
        'date' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
    public function userjoin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
}
