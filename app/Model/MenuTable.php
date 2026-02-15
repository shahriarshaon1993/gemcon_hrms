<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MenuTable extends Model
{
    protected $table = 'menu_tabe';

    protected $fillable =['menu_name','parent_id','order_no','menu_link','has_child','menu_icon','panel_type','status','uid','is_top_bar'];
}
