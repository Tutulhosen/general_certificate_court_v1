<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseActivityLog extends Model
{

    protected $fillable = [
        'user_id',
        'case_register_id',
        'user_roll_id',
        'activity_type',
        'message',
        'office_id',
        'division_id',
        'district_id',
        'upazila_id',
        'old_data',
        'new_data',
        'ip_address',
        'user_agent',
    ];

    public function role() {
        return $this->hasOne(Role::class, 'id', 'user_roll_id');
    }
    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
