<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class GccWarrantExecutor extends Model
{
    protected $fillable = [
        'appeal_id',
        'name',
        'organization',
        'designation',
        'mobile',
        'email',
        
    ];
    //Relation with appeal table
    public function appealInfo()
    {
        return $this->hasOne(GccAppeal::class,'id','appeal_id');
    }

}
