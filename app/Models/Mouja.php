<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mouja extends Model
{
	use HasFactory;

	protected $table = 'mouja';
	public $timestamps = true;

	protected $fillable = [
    'jl_no',
	'mouja_name_bn',
	'mouja_name_en',
    'upazila_id',
	'district_id',
	'division_id',
	'status'
	];
}
