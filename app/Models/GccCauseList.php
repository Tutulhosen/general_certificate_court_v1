<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class GccCauseList extends Model
{
    // protected $connection = 'appeal';
    public function Attachments()
    {
        return $this->hasMany(GccAttachment::class, 'cause_list_id', 'id');
    }
    public function Note()
    {
        return $this->hasOne(GccNote::class, 'cause_list_id', 'id');
    }
    public function appeal()
    {
        return $this->hasOne(GccAppeal::class, 'id', 'appeal_id');
    }
    public function causelistCaseshortdecision()
    {
        return $this->hasMany(GccCauselistCaseshortdecision::class, 'cause_list_id', 'id');
    }
}
