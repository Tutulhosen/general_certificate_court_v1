<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upazila extends Model
{
	use HasFactory;

	protected $table = 'upazila';
	public $timestamps = true;

	protected $fillable = [
	'division_id',
	'district_id',
	'upazila_name_bn',
	'upazila_name_en',
	'upazila_bbs_code',
	'division_bbs_code',
	'status'
	];

	// public function subcategories(){
	// 	return $this->hasMany('App\CaseRegister', 'upazila_id');
	// }
    // public function caseSF(){
	// 	return $this->hasOne(CaseSF::class, 'case_id');
	// }
    // public function court(){
	// 	return $this->hasOne(Court::class, 'id', 'court_id');
	// }
}
