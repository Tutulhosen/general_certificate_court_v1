<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseSFlog extends Model
{

	protected $table = 'case_sf_log';

	protected $fillable = [
	'case_id',
	'sf_log_details',
	'user_id'
	];

	// public function caseRegister(){
	// 	return $this->hasOne(CaseRegister::class, 'id', 'case_id');
	// }
	// public function user(){
	// 	return $this->hasOne(User::class, 'id', 'user_id');
	// }
}
