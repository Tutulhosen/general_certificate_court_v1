<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class GccCitizen extends Model
{
    // protected $connection = 'appeal';

    public function citizenType()
    {
        return $this->belongsToMany(GccCitizenTypes::class,'gcc_appeal_citizens','citizen_id', 'citizen_type_id');

    }
    public function citizensAppealJoin()
    {
        return $this->hasMany(GccAppealCitizen::class,'citizen_id', 'id');
    }
}
