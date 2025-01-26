<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JudgePanel extends Model
{
    use HasFactory;

    protected $table = 'judge_panel';

    protected $fillable = [
            'at_case_id',
            'justis_name',
            'designation'
    ];

    // public function subcategories(){
    //  return $this->hasMany('App\CaseRegister', 'upazila_id');
    // }
}
