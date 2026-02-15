<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class BaseModel extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public static function adminBoot()
    {
        if(Auth::guard('admin')->check()){
            $person_id = Auth::guard('admin')->user()->id;
            self::bootAction($person_id);
        }else{
            parent::boot();
        }
    }

    public static function userBoot()
    {
        if(Auth::guard('user')->check()) {
            $person_id = Auth::guard('user')->user()->id;
            self::bootAction($person_id);
        }else{
            parent::boot();
        }
    }

    public static function bootAction($person_id)
    {
        parent::boot();

        static::creating(function($model) use ($person_id)
        {
            $model->created_by = $person_id;
            $model->updated_by = $person_id;
            $model->valid = 1;
            if(Auth::guard('user')->check()){
                $model->project_id = Auth::guard('user')->user()->project_id;
            }
        });

        static::updating(function($model) use ($person_id)
        {
            $model->updated_by = $person_id;
        });

        static::deleting(function($model) use ($person_id)
        {
            $model->updated_by = $person_id;
            $model->deleted_by = $person_id;
            $model->valid = 0;
            $model->update();
        });
    }

}
