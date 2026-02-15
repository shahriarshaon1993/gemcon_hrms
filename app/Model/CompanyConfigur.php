<?php

namespace App\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class CompanyConfigur extends BaseModel
{
    use LogsActivity;
    protected $table = 'inv_company_configure';

    protected $guarded = array('id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by', 'valid');

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['created','updated','deleted'];
    protected static $logName = 'Company Configur';
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }

    public static function boot()
    {
        parent::adminBoot();
    }

    public function scopeValid($query)
    {
        return $query->where('inv_company_configure.valid', 1);
    }
    
}
