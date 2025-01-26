<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
	use HasFactory;

	protected $table = 'office';
	public $timestamps = false;

	protected $fillable = [
	'division_id',
	'district_id',
	'upazila_id',
	'level',
	'office_name_bn',
	'status'
	];

	public function users() {
		return $this->HasMany(User::class);
	}

	public function district() {
		return $this->hasOne(District::class, 'id', 'district_id');
	}

	public function upazila() {
		return $this->hasOne(Upazila::class, 'id', 'upazila_id');
	}

	// public function subcategories(){
	// 	return $this->hasMany('App\CaseRegister', 'upazila_id');
	// }
}
