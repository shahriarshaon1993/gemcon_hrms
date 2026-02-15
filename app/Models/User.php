<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'employee_id',
        'designation',
        'sap_code',
        'dept_id',
        'role_id',
        'wing_id',
        'status',
        'phone',
        'iactive',
        'password',
        'tour_plan',
        'tour_program',
        'tour_permission',
        'tour_super',
        'vehicle_maintenance',
        'head_of_sales',
        'division_head',
        'divisional_head',
        'sm',
        'asm',
        'dsm',
        'adsm',
        'rsm',
        'tsm',
        'la',
        'hos',
        'vcreateuser',
        'tcreatedate',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
 
    // public static $rules = [ 
    //     'name' => 'required',
    //     'email' => 'required|unique:users,email,'.$this->user->email,
    //     'password' => 'required',
    // ];
 
    const ADMIN_TYPE = 'admin';
    const DEFAULT_TYPE = 'user';

    public function isAdmin()    {        
        return $this->type === self::ADMIN_TYPE;    
    }
    public function deptjoin()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }
    public function rolejoin()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function wingjoin()
    {
        return $this->belongsTo(Wing::class, 'wing_id');
    }
 

}
