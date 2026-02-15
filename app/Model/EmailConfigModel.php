<?php
namespace App\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EmailConfigModel extends Authenticatable
{
	use Notifiable;

    protected $guard ='admin';

    protected $table = 'email_configurations';

    protected $guarded = array('id', 'created_at', 'updated_at','comment');

    public function scopeValid($query)
    {
        return $query->where('email_configurations.valid', 1);
    }
}
