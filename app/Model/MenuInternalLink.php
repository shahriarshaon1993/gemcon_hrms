<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MenuInternalLink extends Model
{
    protected $table = 'menu_internal_link';

    protected $fillable =['menu_id','link_name','menu_uid','link_uid','order_no','panel_type','status'];
}
