<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function office() {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function caseSF(){
		return $this->hasMany(CaseSF::class, 'id', 'user_id');
	}
    public function message_sender(){
		return $this->hasMany(Message::class, 'user_sender', 'id');
	}
    public function message_receiver(){
		return $this->hasMany(Message::class, 'user_receiver', 'id');
	}
}
