<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Notification
 * @package App\Models
 * @version August 23, 2021, 5:57 am UTC
 *
 * @property integer $user_id
 * @property integer $dept_id
 * @property varchar $notification_type
 * @property varchar $notification_section
 * @property integer $status
 * @property varchar $details
 * @property integer $notif_receiver
 */
class Notification extends Model
{
    use SoftDeletes;

    

    public $table = 'notifications';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'dept_id',
        'notification_type',
        'notification_section',
        'status',
        'details',
        'notif_receiver'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'dept_id' => 'integer',
        'status' => 'integer',
        'notif_receiver' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'status' => 'notif_receiver integer'
    ];

    
}
