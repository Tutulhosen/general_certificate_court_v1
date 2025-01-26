<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
	use HasFactory;

	protected $table = 'district';
	public $timestamps = true;

	protected $fillable = [
        'division_id',
        'district_name_bn',
        'district_name_en',
        'district_bbs_code',
        'division_bbs_code',
        'status',

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
