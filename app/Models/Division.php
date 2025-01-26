<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
	use HasFactory;

	protected $table = 'division';
	public $timestamps = true;
	protected $fillable = [
        'division_name_en',
        'division_name_bn',
        'division_bbs_code',
        'status',

	];

	public function districts() {
		return $this->hasMany(District::class, 'division_id', 'id');
	}
}
