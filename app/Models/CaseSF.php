<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseSF extends Model
{

	protected $table = 'case_sf';

	protected $fillable = [
	'',
	'case_id',
	'sf_details',
	'cs_file',
	'sa_file',
	'rs_file',
	'brs_file',
	'send_date',
	'user_id'
	];

	public function caseRegister(){
		return $this->hasOne(CaseRegister::class, 'id', 'case_id');
	}
	public function user(){
		return $this->hasOne(User::class, 'id', 'user_id');
	}
}
