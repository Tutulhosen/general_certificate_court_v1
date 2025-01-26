<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseStatus extends Model
{
    use HasFactory;

    protected $table = 'case_status';
    protected $fillable = [
            'status_name',
            'role_access',
            'status_templete'
    ];

    // public function case_status(){
    //  return $this->hasMany('App\CaseRegister', 'upazila_id');
    // }
}
