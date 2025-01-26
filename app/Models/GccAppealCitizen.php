<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GccAppealCitizen extends Model
{
    // protected $connection = 'appeal';
    public function Citizen()
    {
        return $this->hasOne(GccCitizen::class, 'id', 'citizen_id', );
    }
}
