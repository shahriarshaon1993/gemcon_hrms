<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class TicketSellDetails extends Model
{
    use LogsActivity;
    protected $table = 'ticket_sell_details';

    protected $guarded = array('id','created_at','updated_at');
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['created','updated','deleted'];
    protected static $logName = 'Ticket Sell Details';
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }

    public function scopeValid($query)
	{
		return $query->where('ticket_sell_details.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('ticket_sell_details.project_id', $project_id);
    }
    public function jointicketsell()
    {
        return $this->belongsTo(TicketSell::class, 'sell_id');
        // return $this->join('ticket_sell', 'ticket_sell.id', '=', 'ticket_sell_details.sell_id');
    } 
}
