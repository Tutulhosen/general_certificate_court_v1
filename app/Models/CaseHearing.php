<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseHearing extends Model
{

	protected $table = 'case_hearing';

	protected $fillable = [
	'case_id',
	'hearing_date',
	'hearing_file',
	'hearing_comment',
	'user_id'
	];

	public function case_register(){
		return $this->hasOne(CaseRegister::class, 'id', 'case_id');
	}
	// public function user(){
	// 	return $this->hasOne(User::class, 'id', 'user_id');
	// }
}
