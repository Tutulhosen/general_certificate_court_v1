<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{

	protected $table = 'court';

	protected $fillable = [
	'court_name',
	'ct_id',
	'division_id',
	'district_id',
	'status'
	];

	// public function caseRegister(){
	// 	return $this->hasOne(CaseRegister::class, 'id', 'case_id');
	// }
	// public function user(){
	// 	return $this->hasOne(User::class, 'id', 'user_id');
	// }
}
