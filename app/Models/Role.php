<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	use HasFactory;

	protected $table = 'role';
	// public $timestamps = true;   

	protected $fillable = [
	'role_name'
	];

	public function users() {
		return $this->HasMany(User::class);
	}

	// public function subcategories(){
	// 	return $this->hasMany('App\CaseRegister', 'upazila_id');
	// }
}
