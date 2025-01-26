<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseBibadi extends Model
{
	use HasFactory;

	protected $table = 'case_bibadi';
	public $timestamps = false;   

	protected $fillable = [
			'case_id','bibadi_name','bibadi_spouse_name','bibadi_address'
	];

	// public function subcategories(){
	// 	return $this->hasMany('App\CaseRegister', 'upazila_id');
	// }
}
