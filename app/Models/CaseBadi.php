<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseBadi extends Model
{
	use HasFactory;

	protected $table = 'case_badi';
	public $timestamps = false;   

	protected $fillable = [
			'case_id','badi_name','badi_spouse_name','badi_address'
	];

	// public function subcategories(){
	// 	return $this->hasMany('App\CaseRegister', 'upazila_id');
	// }
}