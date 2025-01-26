<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class GccNote extends Model
{
    // protected $connection = 'appeal';
    public $timestamps = false;

   public function noteCauseList()
   {
       return $this->belongsTo(GccCauseList::class, 'cause_list_id', 'id');
   }
   public function attachments()
   {
       return $this->hasMany(GccAttachment::class, 'cause_list_id', 'cause_list_id');
   }
}
