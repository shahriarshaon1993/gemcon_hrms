<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class DocumentFolder extends Model
{
   protected $table = 'document_folders';

    protected $guarded = array('id','created_at','updated_at');

    public function scopeValid($query)
  {
      return $query->where('document_folders.valid', 1);
    }
    public function scopeProject($query)
    {
        $project_id = Auth::guard('user')->user()->project_id;
        return $query->where('document_folders.project_id', $project_id);
    }   
}