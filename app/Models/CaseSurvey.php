<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseSurvey extends Model
{
	use HasFactory;

	protected $table = 'case_survey';
	public $timestamps = false;   

	protected $fillable = [
			'case_id','st_id','khotian_no ','daag_no','lt_id','land_size','land_demand'
	];

	// public function subcategories(){
	// 	return $this->hasMany('App\CaseRegister', 'upazila_id');
	// }
}
